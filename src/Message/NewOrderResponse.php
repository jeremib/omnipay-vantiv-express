<?php

namespace Omnipay\VantivExpress\Message;

use function json_encode;
use SimpleXMLElement;
use Omnipay\Common\Message\AbstractResponse;

/**
 *  Vantiv Express Response
 */
class NewOrderResponse extends AbstractResponse
{
    public function getTransactionReference()
    {
        // return $this->data->Response->Transaction->TransactionID->__toString();

        return [
            'trans_reference'   => $this->data->Response->Transaction->TransactionID->__toString(),
            'auth_code'         => $this->data->Response->Transaction->ApprovalNumber->__toString(),
            ];
    }

    public function isApproved()
    {
        return $this->data->Response->ExpressResponseCode->__toString() === '0';
    }

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
        return $this->data->Response->ExpressResponseCode->__toString() == '0';
    }
}
