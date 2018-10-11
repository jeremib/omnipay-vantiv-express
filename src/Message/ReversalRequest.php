<?php

namespace Omnipay\VantivExpress\Message;

use SimpleXMLElement;
use Omnipay\Common\Exception\InvalidResponseException;

/**
 *  Vantiv Express Reversal Request
 */
class ReversalRequest extends AbstractRequest
{
    protected function getXmlElement($method = 'CreditCard') {
        if ( $method == 'CC' ) {
            return new SimpleXMLElement('<CreditCardReversal xmlns="https://transaction.elementexpress.com"><Credentials></Credentials><Application></Application><Terminal></Terminal><Card></Card><Address></Address><Transaction></Transaction></CreditCardReversal>');
        } elseif ( $method == 'DEBIT' ) {
            return new SimpleXMLElement('<DebitCardReversal xmlns="https://transaction.elementexpress.com"><Credentials></Credentials><Application></Application><Terminal></Terminal><Card></Card><Address></Address><Transaction></Transaction></DebitCardReversal>');
        } else {
            return new SimpleXMLElement('<CheckReversal xmlns="https://transaction.elementexpress.com"><Credentials></Credentials><Application></Application><Terminal></Terminal><DemandDepositAccount></DemandDepositAccount><Address></Address><Transaction></Transaction></CheckReversal>');
        }
    }
    protected function xmlData()
    {
        $data = $this->getXmlElement($this->getOriginalMethod());
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
