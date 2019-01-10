<?php

namespace Omnipay\VantivExpress\Message;

use function json_encode;
use SimpleXMLElement;
use Omnipay\Common\Message\AbstractResponse;

/**
 *  Vantiv Express Response
 */
class TokenCreateResponse extends AbstractResponse
{
    public function getTransactionReference()
    {
        return [
            'trans_reference'       => $this->data->Response->ServicesID->__toString(),
            'token_id'              => isset($this->data->Response->Token) ? $this->data->Response->Token->TokenID->__toString() : null,
            'token_provider'        => isset($this->data->Response->Token) ? $this->data->Response->Token->TokenProvider->__toString() : null,
            'card_logo'             => isset($this->data->Response->Card) ? $this->data->Response->Card->CardLogo->__toString() : null,
            'card_exp_m'            => isset($this->data->Response->Card) ? $this->data->Response->Card->ExpirationMonth->__toString() : null,
            'card_exp_y'            => isset($this->data->Response->Card) ? $this->data->Response->Card->ExpirationYear->__toString() : null,
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
