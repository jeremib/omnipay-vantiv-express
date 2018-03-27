<?php

namespace Omnipay\VantivExpress\Message;

use Omnipay\Common\Exception\InvalidResponseException;
use SimpleXMLElement;

/**
 *  Vantiv Express New Order Request
 */
abstract class NewOrderRequest extends AbstractRequest
{
    protected function getXmlElement($method = 'CreditCard') {
        if ( $method == 'CreditCard' ) {
            return new SimpleXMLElement('<CreditCardSale xmlns="https://transaction.elementexpress.com"><Credentials></Credentials><Application></Application><Terminal></Terminal><Card></Card><Address></Address><Transaction></Transaction></CreditCardSale>');
        } else {
            return new SimpleXMLElement('<CheckSale xmlns="https://transaction.elementexpress.com"><Credentials></Credentials><Application></Application><Terminal></Terminal><DemandDepositAccount></DemandDepositAccount><Address></Address><Transaction></Transaction></CreditCheckSaleCardSale>');
        }
    }

    protected function xmlData()
    {
        


        if ($card = $this->getCard()) {
            $data = $this->getXmlElement('CreditCard');
            $card = $data->Card;
            $card->CardNumber       = $this->getCard()->getNumber();
            $card->ExpirationMonth  = $this->getCard()->getExpiryDate('m');
            $card->ExpirationYear   = $this->getCard()->getExpiryDate('y');
            $card->CVV              = $this->getCard()->getCvv();
        }elseif ( $this->getBCRtNum() ) {
            $data = $this->getXmlElement('Check');
            $depositAccount = $data->DemandDepositAccount;
            $depositAccount->AccountNumber  = $this->getCheckAccountNumber();
            $depositAccount->RoutingNumber  = $this->setCheckRoutingNumber();
            $depositAccount->DDAAccountType = 0;
        }

        $credentials = $data->Credentials;

        $credentials->AccountID     = $this->getAccountID();
        $credentials->AccountToken  = $this->getAccountToken();
        $credentials->AcceptorID    = $this->getAcceptorID();

        $application = $data->Application;
        $application->ApplicationID         = $this->getApplicationID();
        $application->ApplicationName       = $this->getApplicationName();
        $application->ApplicationVersion    = $this->getApplicationVersion();

        $terminal = $data->Terminal;
        $terminal->TerminalID               = $this->getTerminalID();
        $terminal->CardholderPresentCode    = $this->getCardholderPresentCode();
        $terminal->CardInputCode            = $this->getCardInputCode();
        $terminal->TerminalCapabilityCode   = $this->getTerminalCapabilityCode();
        $terminal->TerminalEnvironmentCode  = $this->getTerminalEnvironmentCode();
        $terminal->CardPresentCode          = $this->getCardPresentCode();
        $terminal->MotoECICode              = $this->getMotoECICode();
        $terminal->CVVPresenceCode          = $this->getCVVPresenceCode();



        $address = $data->Address;
        $address->BillingName          = $this->getCard()->getCvv();
        $address->BillingAddress1      = $this->getCard()->getBillingAddress1();
        $address->BillingAddress2      = $this->getCard()->getBillingAddress2();
        $address->BillingCity          = $this->getCard()->getBillingCity();
        $address->BillingState         = $this->getCard()->getBillingState();
        $address->BillingZipcode       = $this->getCard()->getBillingPostcode();


        $transaction = $data->Transaction;
        $transaction->TransactionAmount = $this->getAmount();
        $transaction->ReferenceNumber   = time();

        return $data;
    }

    public function getData()
    {
        $this->validate('ReferenceNumber');
        return $this->xmlData()->asXML();
    }

    protected function createResponse($data)
    {
        if ($data->Response) {
            return $this->response = new NewOrderResponse($this, $data);
        } else {
            throw new InvalidResponseException();
        }
    }
}
