<?php

namespace Omnipay\VantivExpress;

use Omnipay\Common\AbstractGateway;

/**
 * Vantiv Express Gateway
 *
 * @link https://developer.vantiv.com/community/enterprise/blog/2016/05/11/getting-started-with-vantivs-express-api
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Vantiv Express';
    }

    public function getDefaultParameters()
    {
        return [
            'AccountID'                 => '',
            'AccountToken'              => '',
            'AcceptorID'                => '',
            'ApplicationID'             => '',
            'ApplicationName'           => '',
            'ApplicationVersion'        => '',
            'TerminalID'                => '01',
            'CardholderPresentCode'     => 7,
            'CardInputCode'             => 4,
            'TerminalCapabilityCode'    => 5,
            'TerminalEnvironmentCode'   => 6,
            'CardPresentCode'           => 3,
            'MotoECICode'               => 7,
            'CVVPresenceCode'           => 1,
            'MarketCode'                => 3,
            'TerminalType'              => 2,
            'ReferenceNumber'           => '',
            'OriginalMethod'            => '',
            'TokenID'                   => '',
            'TokenProvider'             => ''

        ];
    }

    public function getAccountID()
    {
        return $this->getParameter('AccountID');
    }

    public function setAccountID($value)
    {
        return $this->setParameter('AccountID', $value);
    }

    public function getAccountToken()
    {
        return $this->getParameter('AccountToken');
    }

    public function setAccountToken($value)
    {
        return $this->setParameter('AccountToken', $value);
    }

    public function getAcceptorID()
    {
        return $this->getParameter('AcceptorID');
    }

    public function setAcceptorID($value)
    {
        return $this->setParameter('AcceptorID', $value);
    }

    public function getApplicationID()
    {
        return $this->getParameter('ApplicationID');
    }

    public function setApplicationID($value)
    {
        return $this->setParameter('ApplicationID', $value);
    }

    public function getApplicationName()
    {
        return $this->getParameter('ApplicationName');
    }

    public function setApplicationName($value)
    {
        return $this->setParameter('ApplicationName', $value);
    }

    public function getApplicationVersion()
    {
        return $this->getParameter('ApplicationVersion');
    }

    public function setApplicationVersion($value)
    {
        return $this->setParameter('ApplicationVersion', $value);
    }

    public function getTerminalID()
    {
        return $this->getParameter('TerminalID');
    }

    public function setTerminalType($value)
    {
        return $this->setParameter('TerminalType', $value);
    }

    public function getTerminalType()
    {
        return $this->getParameter('TerminalType');
    }

    public function setTerminalID($value)
    {
        return $this->setParameter('TerminalID', $value);
    }

    public function getCardholderPresentCode()
    {
        return $this->getParameter('CardholderPresentCode');
    }

    public function setCardholderPresentCode($value)
    {
        return $this->setParameter('CardholderPresentCode', $value);
    }

    public function getCardInputCode()
    {
        return $this->getParameter('CardInputCode');
    }

    public function setCardInputCode($value)
    {
        return $this->setParameter('CardInputCode', $value);
    }

    public function getTerminalCapabilityCode()
    {
        return $this->getParameter('TerminalCapabilityCode');
    }

    public function setTerminalCapabilityCode($value)
    {
        return $this->setParameter('TerminalCapabilityCode', $value);
    }

    public function getTerminalEnvironmentCode()
    {
        return $this->getParameter('TerminalEnvironmentCode');
    }

    public function setTerminalEnvironmentCode($value)
    {
        return $this->setParameter('TerminalEnvironmentCode', $value);
    }

    public function getCardPresentCode()
    {
        return $this->getParameter('CardPresentCode');
    }

    public function setCardPresentCode($value)
    {
        return $this->setParameter('CardPresentCode', $value);
    }

    public function getMotoECICode()
    {
        return $this->getParameter('MotoECICode');
    }

    public function setMotoECICode($value)
    {
        return $this->setParameter('MotoECICode', $value);
    }

    public function getCVVPresenceCode()
    {
        return $this->getParameter('CVVPresenceCode');
    }

    public function setCVVPresenceCode($value)
    {
        return $this->setParameter('CVVPresenceCode', $value);
    }

    public function getMarketCode()
    {
        return $this->getParameter('MarketCode');
    }

    public function setMarketCode($value)
    {
        return $this->setParameter('MarketCode', $value);
    }

    public function getReferenceNumber()
    {
        return $this->getParameter('ReferenceNumber');
    }

    public function setReferenceNumber($value)
    {
        return $this->setParameter('ReferenceNumber', $value);
    }
    public function getOriginalMethod()
    {
        return $this->getParameter('OriginalMethod');
    }

    public function setOriginalMethod($value)
    {
        return $this->setParameter('OriginalMethod', $value);
    }

    public function getTokenProvider()
    {
        return $this->getParameter('TokenProvider');
    }

    public function setTokenProvider($value)
    {
        return $this->setParameter('TokenProvider', $value);
    }

    public function getTokenID()
    {
        return $this->getParameter('TokenID');
    }

    public function setTokenID($value)
    {
        return $this->setParameter('TokenID', $value);
    }

    public function getCardLogo()
    {
        return $this->getParameter('CardLogo');
    }

    public function setCardLogo($value)
    {
        return $this->setParameter('CardLogo', $value);
    }

    public function getExpirationMonth()
    {
        return $this->getParameter('ExpirationMonth');
    }

    public function setExpirationMonth($value)
    {
        return $this->setParameter('ExpirationMonth', $value);
    }

    public function getExpirationYear()
    {
        return $this->getParameter('ExpirationYear');
    }

    public function setExpirationYear($value)
    {
        return $this->setParameter('ExpirationYear', $value);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\VantivExpress\Message\PurchaseRequest', $parameters);
    }

    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\VantivExpress\Message\AuthorizeRequest', $parameters);
    }

    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\VantivExpress\Message\RefundRequest', $parameters);
    }

    public function capture(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\VantivExpress\Message\MarkForCaptureRequest', $parameters);
    }

    public function void(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\VantivExpress\Message\VoidRequest', $parameters);
    }

    public function reverse(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\VantivExpress\Message\ReversalRequest', $parameters);
    }

    public function token(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\VantivExpress\Message\TokenCreateRequest', $parameters);
    }
    public function query(array $parameters = array()) {
        return $this->createRequest('\Omnipay\VantivExpress\Message\QueryRequest', $parameters);
    }
}
