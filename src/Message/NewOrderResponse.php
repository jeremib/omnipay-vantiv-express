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
            'acquirer_data'     => $this->data->Response->Transaction->AcquirerData->__toString(),
            'reference_number'  => $this->data->Response->Transaction->ReferenceNumber->__toString(),
            'avs_response_code'     => isset($this->data->Response->Card->AVSResponseCode) ? $this->data->Response->Card->AVSResponseCode->__toString() : null,
            'cvv_response_code'     => isset($this->data->Response->Card->CVVResponseCode) ? $this->data->Response->Card->CVVResponseCode->__toString() : null,
            'card_logo'             => isset($this->data->Response->Card->CardLogo) ? $this->data->Response->Card->CardLogo->__toString() : null,
            'card_number_masked'    => isset($this->data->Response->Card->CardNumberMasked) ? $this->data->Response->Card->CardNumberMasked->__toString() : null,
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
