<?php

namespace Omnipay\VantivExpress\Message;

use SimpleXMLElement;
use Omnipay\Common\Exception\InvalidResponseException;

/**
 *  Vantiv Express Query Request
 */
class QueryRequest extends AbstractRequest
{
    protected $testUrls = array(
        'https://certreporting.elementexpress.com',
    );

    protected $liveUrls = array(
        'https://reporting.elementexpress.com/',
    );

    protected function getXmlElement($method = 'CreditCard') {
        return new SimpleXMLElement('<TransactionQuery xmlns="https://reporting.elementexpress.com"><Credentials></Credentials><Application></Application><Parameters></Parameters></TransactionQuery>');
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

        $parameters = $data->Parameters;
        if ( $this->getReferenceNumber() ) {
            $parameters->ReferenceNumber   = $this->getReferenceNumber();
        }

        if ( $this->getTransactionId() ) {
            $parameters->TransactionID         = $this->getTransactionId();
        }

        return $data;
    }

    public function getData()
    {
        return $this->xmlData()->asXML();
    }

    protected function createResponse($data)
    {
        if ($data->Response) {
            return $this->response = new QueryResponse($this, $data);
        } else {
            throw new InvalidResponseException();
        }
    }
}
