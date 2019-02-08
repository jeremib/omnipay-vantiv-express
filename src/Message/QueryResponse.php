<?php

namespace Omnipay\VantivExpress\Message;

use Omnipay\Common\Exception\InvalidResponseException;
use SimpleXMLElement;
use Omnipay\Common\Message\AbstractResponse;

/**
 *  Vantiv Express Quick Response
 *
 *  Quote: When a transaction has an error condition, such as a time out condition or a poorly formed
 *         message request, the gateway will generate a quick error message back to the requestor. This
 *         error response takes the form of a "Quick Response".
 */
class QueryResponse extends AbstractResponse
{
    public function getCode()
    {
        return $this->data->Response->ExpressResponseCode->__toString();
    }

    public function getMessage()
    {
        return $this->data->Response->ExpressResponseMessage->__toString();
    }

    public function isSuccessful()
    {
        return $this->data->Response->ExpressResponseCode->__toString() == 0;
    }

    public function getReportingData() {
        $results = [];
        if ( $this->data->Response->ExpressResponseCode->__toString() == 90 ) {
            return [];
        }elseif ( $this->data->Response->ExpressResponseCode->__toString() != 0 ) {
            throw new InvalidResponseException($this->data->Response->ExpressResponseMessage->__toString(), $this->data->Response->ExpressResponseCode->__toString());
        }
        foreach($this->data->Response->ReportingData->Items->Item as $el) {
            $results[] = (array)$el;
        }
        return $results;
    }
}
