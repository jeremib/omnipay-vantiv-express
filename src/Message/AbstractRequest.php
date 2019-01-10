<?php

namespace Omnipay\VantivExpress\Message;

/**
 *  Vantiv Express Abstract Request
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $retryCount = 0;

    protected $testUrls = array(
        'https://certtransaction.elementexpress.com',
    );

    protected $liveUrls = array(
        'https://transaction.elementexpress.com/',
    );

    public function sendData($data)
    {
        $httpResponse = $this->httpClient->request('post',
            $this->getEndpoint(),
            $this->getHeaders(),
            $data,
            array('exceptions' => false)
        );
        return $this->createResponse(simplexml_load_string($httpResponse->getBody()->__toString()));
    }

    abstract protected function createResponse($data);
    abstract protected function getXmlElement();

    protected function getHeaders()
    {
        return array(
            'Content-type' => 'text/xml; charset=UTF-8',
            'Content-transfer-encoding' => 'text',
        );
    }

    public function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint() : $this->liveEndpoint();
    }

    public function testEndpoint()
    {
        // TODO: retry logic
        return $this->testUrls[0];
    }

    public function liveEndpoint()
    {
        // TODO: retry logic
        return $this->liveUrls[0];
    }

    public function getOrderId()
    {
        return $this->getParameter('orderId');
    }

    public function setOrderId($value)
    {
        return $this->setParameter('orderId', $value);
    }

    public function getAccountID()
    {
        return $this->getParameter('AccountID');
    }

    public function setAccountID($value)
    {
        return $this->setParameter('AccountID', $value);
    }

    public function getAccountToken()
    {
        return $this->getParameter('AccountToken');
    }

    public function setAccountToken($value)
    {
        return $this->setParameter('AccountToken', $value);
    }

    public function getAcceptorID()
    {
        return $this->getParameter('AcceptorID');
    }

    public function setAcceptorID($value)
    {
        return $this->setParameter('AcceptorID', $value);
    }

    public function getApplicationID()
    {
        return $this->getParameter('ApplicationID');
    }

    public function setApplicationID($value)
    {
        return $this->setParameter('ApplicationID', $value);
    }

    public function getApplicationName()
    {
        return $this->getParameter('ApplicationName');
    }

    public function setApplicationName($value)
    {
        return $this->setParameter('ApplicationName', $value);
    }

    public function getApplicationVersion()
    {
        return $this->getParameter('ApplicationVersion');
    }

    public function setApplicationVersion($value)
    {
        return $this->setParameter('ApplicationVersion', $value);
    }

    public function getTerminalID()
    {
        return $this->getParameter('TerminalID');
    }

    public function setTerminalID($value)
    {
        return $this->setParameter('TerminalID', $value);
    }

    public function getCardholderPresentCode()
    {
        return $this->getParameter('CardholderPresentCode');
    }

    public function setCardholderPresentCode($value)
    {
        return $this->setParameter('CardholderPresentCode', $value);
    }

    public function getCardInputCode()
    {
        return $this->getParameter('CardInputCode');
    }

    public function setCardInputCode($value)
    {
        return $this->setParameter('CardInputCode', $value);
    }

    public function getTerminalCapabilityCode()
    {
        return $this->getParameter('TerminalCapabilityCode');
    }

    public function setTerminalCapabilityCode($value)
    {
        return $this->setParameter('TerminalCapabilityCode', $value);
    }

    public function getTerminalType()
    {
        return $this->getParameter('TerminalType');
    }

    public function setTerminalType($value)
    {
        return $this->setParameter('TerminalType', $value);
    }

    public function getTerminalEnvironmentCode()
    {
        return $this->getParameter('TerminalEnvironmentCode');
    }

    public function setTerminalEnvironmentCode($value)
    {
        return $this->setParameter('TerminalEnvironmentCode', $value);
    }

    public function getCardPresentCode()
    {
        return $this->getParameter('CardPresentCode');
    }

    public function setCardPresentCode($value)
    {
        return $this->setParameter('CardPresentCode', $value);
    }

    public function getMotoECICode()
    {
        return $this->getParameter('MotoECICode');
    }

    public function setMotoECICode($value)
    {
        return $this->setParameter('MotoECICode', $value);
    }

    public function getCVVPresenceCode()
    {
        return $this->getParameter('CVVPresenceCode');
    }

    public function setCVVPresenceCode($value)
    {
        return $this->setParameter('CVVPresenceCode', $value);
    }

    public function getMarketCode()
    {
        return $this->getParameter('MarketCode');
    }

    public function setMarketCode($value)
    {
        return $this->setParameter('MarketCode', $value);
    }

    public function getTransactionId()
    {
        return $this->getParameter('TransactionId');
    }

    public function setTransactionId($value)
    {
        return $this->setParameter('TransactionId', $value);
    }

    public function getReversalType()
    {
        return $this->getParameter('ReversalType');
    }

    public function setReversalType($value)
    {
        return $this->setParameter('ReversalType', $value);
    }

    public function getReferenceNumber()
    {
        return $this->getParameter('ReferenceNumber');
    }

    public function setReferenceNumber($value)
    {
        return $this->setParameter('ReferenceNumber', $value);
    }


    public function getCheckAccountNumber()
    {
        return $this->getParameter('CheckAccountNumber');
    }

    public function setCheckAccountNumber($value)
    {
        return $this->setParameter('CheckAccountNumber', $value);
    }

    public function getCheckRoutingNumber()
    {
        return $this->getParameter('CheckRoutingNumber');
    }

    public function setCheckRoutingNumber($value)
    {
        return $this->setParameter('CheckRoutingNumber', $value);
    }
    public function getOriginalMethod()
    {
        return $this->getParameter('OriginalMethod');
    }

    public function setOriginalMethod($value)
    {
        return $this->setParameter('OriginalMethod', $value);
    }

    public function getAmount()
    {
        $this->setAmount((float)$amount = $this->getParameter('amount'));
        return parent::getAmount(); // TODO: Change the autogenerated stub
    }
}
