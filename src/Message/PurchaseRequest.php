<?php

namespace Omnipay\VantivExpress\Message;

use SimpleXMLElement;

/**
 *  Vantiv Express Purchase Request
 */
class PurchaseRequest extends NewOrderRequest
{
    protected function getMessageType()
    {
        return 'AC';
    }

    public function getData()
    {
        $this->validate('amount', 'card', 'orderId');
        return parent::getData();
    }
}
