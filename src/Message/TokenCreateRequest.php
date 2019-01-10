<?php

namespace Omnipay\VantivExpress\Message;

use Omnipay\Common\Exception\InvalidResponseException;
use SimpleXMLElement;

/**
 *  Vantiv Express Token Create Request
 */
class TokenCreateRequest extends AbstractRequest
{
    protected $testUrls = array(
        'https://certservices.elementexpress.com',
    );

    protected $liveUrls = array(
        'https://services.elementexpress.com/',
    );

    protected function getXmlElement() {
            return new SimpleXMLElement('<TokenCreateWithTransID xmlns="https://services.elementexpress.com"><Credentials></Credentials><Application></Application><Transaction></Transaction><Token></Token></TokenCreateWithTransID>');
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

        $transaction = $data->Transaction;
        $transaction->TransactionID     = $this->getTransactionId();

        $data->Token->TokenProvider             = 2;

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
            return $this->response = new TokenCreateResponse($this, $data);
        } else {
            throw new InvalidResponseException();
        }
    }
}
