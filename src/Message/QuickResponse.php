<?php

namespace Omnipay\VantivExpress\Message;

use SimpleXMLElement;
use Omnipay\Common\Message\AbstractResponse;

/**
 *  Vantiv Express Quick Response
 *
 *  Quote: When a transaction has an error condition, such as a time out condition or a poorly formed
 *         message request, the gateway will generate a quick error message back to the requestor. This
 *         error response takes the form of a "Quick Response".
 */
class QuickResponse extends AbstractResponse
{
    public function getCode()
    {
        return $this->data->QuickResp->ProcStatus->__toString();
    }

    public function getMessage()
    {
        return $this->data->QuickResp->StatusMsg->__toString();
    }

    public function isSuccessful()
    {
        return false;
    }
}
