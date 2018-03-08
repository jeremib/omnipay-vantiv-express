<?php

namespace Omnipay\VantivExpress\Message;

use SimpleXMLElement;

/**
 *  Vantiv Express Refund Request
 */
class RefundRequest extends AbstractRequest
{
    protected function getXmlElement() {
        return new SimpleXMLElement('<CreditCardSale xmlns="https://transaction.elementexpress.com"><Credentials></Credentials><Application></Application><Terminal></Terminal><Card></Card><Address></Address><Transaction></Transaction></CreditCardSale>');
    }

    protected function xmlData()
    {
        $data = $this->getXmlElement();
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

        $transaction = $data->Transaction;
        $transaction->TransactionAmount = $this->getAmountInteger();
        $transaction->ReferenceNumber   = time();
        $transaction->TransactionID     = $this->getTransactionId();

        return $data;
    }

    public function getData()
    {
        $this->validate('TransactionId');
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