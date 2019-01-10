<?php

namespace Omnipay\VantivExpress\Message;

use SimpleXMLElement;
use Omnipay\Common\Message\AbstractResponse;

/**
 *  Vantiv Express Reversal Response
 */
class ReversalResponse extends NewOrderResponse
{
    public function getTransactionReference()
    {
        return [
            'trans_reference'   => $this->data->Response->Transaction->TransactionID->__toString(),
            'auth_code'         => $this->data->Response->Transaction->ApprovalNumber->__toString(),
            'acquirer_data'     => $this->data->Response->Transaction->AcquirerData->__toString(),
            'reference_number'  => $this->data->Response->Transaction->ReferenceNumber->__toString(),
        ];
    }
}
