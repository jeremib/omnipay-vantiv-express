<?php

namespace Omnipay\VantivExpress\Message;

use SimpleXMLElement;

/**
 *  Vantiv Express Authorize Request
 */
class AuthorizeRequest extends NewOrderRequest
{
    protected function getXmlElement() {
        return new SimpleXMLElement('<CreditCardAuthorization xmlns="https://transaction.elementexpress.com"><Credentials></Credentials><Application></Application><Terminal></Terminal><Card></Card><Address></Address><Transaction></Transaction></CreditCardAuthorization>');
    }
}
