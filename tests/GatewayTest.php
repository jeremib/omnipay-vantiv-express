<?php

namespace Omnipay\VantivExpress;

use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->initialize([
            'AccountID'                 => '1051430',
            'AccountToken'              => 'C7710AA0B22905C681D34DB8A42B3ED1D7DC7BB8532E15E16B925697E13C0A49C5047B01',
            'AcceptorID'                => '3928907',
            'ApplicationID'             => '8985',
            'ApplicationName'           => 'MyExpressTest',
            'ApplicationVersion'        => '1.0.0',
            'TerminalID'                => '01',
        ]);
    }

    public function testPurchaseSuccess()
    {
        $this->setMockHttpResponse('PurchaseSuccess.txt');
        $request = $this->gateway->purchase(array(
          'amount' => '12.00',
          'orderId' => '123',
          'card'   => $this->getValidCard()
        ));

        $this->assertInstanceOf('\Omnipay\VantivExpress\Message\PurchaseRequest', $request);
        $this->assertSame('12.00', $request->getAmount());

        $response = $request->send();

        $this->assertTrue($response->isApproved());
        $this->assertSame('3333348', $response->getTransactionReference()['trans_reference']);
        $this->assertTrue($response->isApproved());
        $this->assertSame('0', $response->getCode());
        $this->assertSame('Approved', $response->getMessage());
    }

    public function testPurchaseError()
    {
        $this->setMockHttpResponse('ErrorResponse.txt');
        $card = $this->getValidCard();
        $card['number'] = 'zzz';
        $request = $this->gateway->purchase(array(
          'amount' => '12.00',
          'orderId' => '123',
          'card'   => $card
        ));

        $this->assertInstanceOf('\Omnipay\VantivExpress\Message\PurchaseRequest', $request);
        $this->assertSame('12.00', $request->getAmount());

        $response = $request->send();

        $this->assertFalse($response->isApproved());
        $this->assertSame('INVALID CARD INFO', $response->getMessage());
        $this->assertSame('101', $response->getCode());
    }

    public function testAuthorizeSuccess()
    {
        $this->setMockHttpResponse('AuthorizeSuccess.txt');
        $request = $this->gateway->authorize(array(
          'amount' => '12.00',
          'orderId' => '123',
          'card'   => $this->getValidCard()
        ));

        $this->assertInstanceOf('\Omnipay\VantivExpress\Message\AuthorizeRequest', $request);
        $this->assertSame('12.00', $request->getAmount());

        $response = $request->send();

        $this->assertSame('3334116', $response->getTransactionReference()['trans_reference']);
        $this->assertTrue($response->isApproved());
        $this->assertSame('0', $response->getCode());
        $this->assertSame('Approved', $response->getMessage());
    }

    public function testRefundSuccess()
    {
        $this->setMockHttpResponse('RefundSuccess.txt');
        $request = $this->gateway->refund(array(
          'amount' => '12.00',
          'TransactionId' => '3334668',
        ));

        $this->assertInstanceOf('\Omnipay\VantivExpress\Message\RefundRequest', $request);
        $this->assertSame('12.00', $request->getAmount());

        $response = $request->send();

        $this->assertSame('3334677', $response->getTransactionReference()['trans_reference']);
        $this->assertTrue($response->isApproved());
    }

    public function testCaptureLockedDown()
    {
        $this->setMockHttpResponse('CaptureLockedDown.txt');
        $request = $this->gateway->capture(array(
          'amount' => '1.00',
          'TransactionId' => '3335903',
        ));

        $this->assertInstanceOf('\Omnipay\VantivExpress\Message\MarkForCaptureRequest', $request);
        $this->assertSame('1.00', $request->getAmount());

        $response = $request->send();

        $this->assertFalse($response->isApproved());
        $this->assertSame('Invalid Transaction Status', $response->getMessage());
        $this->assertSame('103', $response->getCode());
    }

    public function testCaptureSuccess()
    {
        $this->setMockHttpResponse('CaptureSuccess.txt');
        $request = $this->gateway->capture(array(
          'amount' => '1.00',
          'TransactionId' => '3335903',
        ));

        $this->assertInstanceOf('\Omnipay\VantivExpress\Message\MarkForCaptureRequest', $request);
        $this->assertSame('1.00', $request->getAmount());

        $response = $request->send();

        $this->assertTrue($response->isApproved());
        $this->assertSame('3335993', $response->getTransactionReference()['trans_reference']);
        $this->assertTrue($response->isApproved());
    }

    public function testReversalSuccess()
    {
        $this->setMockHttpResponse('ReversalSuccess.txt');
        $request = $this->gateway->void(array(
          'amount' => '1.00',
          'TransactionId' => '3335903',
          'ReversalType' => 1
        ));

        $this->assertInstanceOf('\Omnipay\VantivExpress\Message\ReversalRequest', $request);
        $this->assertSame('1.00', $request->getAmount());

        $response = $request->send();

        $this->assertTrue($response->isApproved());
        $this->assertSame('3337678', $response->getTransactionReference()['trans_reference']);
    }

    public function testReversalInvalidState()
    {
        $this->setMockHttpResponse('ReversalInvalidStatus.txt');
        $request = $this->gateway->void(array(
            'amount' => '1.00',
            'TransactionId' => '3335903',
            'ReversalType' => 1
        ));

        $this->assertInstanceOf('\Omnipay\VantivExpress\Message\ReversalRequest', $request);
        $this->assertSame('1.00', $request->getAmount());

        $response = $request->send();

        $this->assertFalse($response->isApproved());
        $this->assertSame('Invalid Transaction Status', $response->getMessage());
        $this->assertSame('103', $response->getCode());
    }
}
