<?php

namespace Omnipay\VantivExpress\Message;

use SimpleXMLElement;
use Omnipay\Common\Exception\InvalidResponseException;

/**
 *  Vantiv Express Reversal Request
 */
class ReversalRequest extends AbstractRequest
{
    protected function getXmlElement() {
        return new SimpleXMLElement('<CreditCardReversal xmlns="https://transaction.elementexpress.com"><Credentials></Credentials><Application></Application><Terminal></Terminal><Transaction></Transaction></CreditCardReversal>');
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
        $transaction->TransactionAmount = $this->getAmount();
        $transaction->ReferenceNumber   = $this->getReferenceNumber();
        $transaction->TransactionID     = $this->getTransactionId();
        $transaction->ReversalType      = $this->getReversalType();

        return $data;
    }

    public function getData()
    {
        $this->validate('TransactionId', 'ReversalType');
        return $this->xmlData()->asXML();
    }

    protected function createResponse($data)
    {
        if ($data->Response) {
            return $this->response = new ReversalResponse($this, $data);
        } elseif ($data->QuickResp) {
            return $this->response = new QuickResponse($this, $data);
        } else {
            throw new InvalidResponseException();
        }
    }
}
