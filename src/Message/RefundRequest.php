<?php

namespace Omnipay\VantivExpress\Message;

use SimpleXMLElement;

/**
 *  Vantiv Express Refund Request
 */
class RefundRequest extends AbstractRequest
{
    protected function getXmlElement($method = 'CreditCard') {
        if ( $method == 'CC' ) {
            return new SimpleXMLElement('<CreditCardReturn xmlns="https://transaction.elementexpress.com"><Credentials></Credentials><Application></Application><Terminal></Terminal><Card></Card><Address></Address><Transaction></Transaction></CreditCardReturn>');
        } elseif ( $method == 'DEBIT' ) {
            return new SimpleXMLElement('<DebitCardReturn xmlns="https://transaction.elementexpress.com"><Credentials></Credentials><Application></Application><Terminal></Terminal><Card></Card><Address></Address><Transaction></Transaction></DebitCardReturn>');
        } else {
            return new SimpleXMLElement('<CheckReturn xmlns="https://transaction.elementexpress.com"><Credentials></Credentials><Application></Application><Terminal></Terminal><DemandDepositAccount></DemandDepositAccount><Address></Address><Transaction></Transaction></CheckReturn>');
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

        if ( $this->getTokenProvider() == 2 ) {
            $data->Token->TokenProvider     = $this->getTokenProvider();
            $data->Token->TokenID           = $this->getTokenID();
            $data->Card->CardLogo           = $this->getCardLogo();
        } else {
            $transaction->TransactionID     = $this->getTransactionId();
        }



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
