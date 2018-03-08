<?php

namespace Omnipay\VantivExpress\Message;

use Omnipay\Common\Exception\InvalidResponseException;
use SimpleXMLElement;

/**
 *  Vantiv Express New Order Request
 */
abstract class NewOrderRequest extends AbstractRequest
{
    protected function getXmlElement() {
        return new SimpleXMLElement('<CreditCardSale xmlns="https://transaction.elementexpress.com"><Credentials></Credentials><Application></Application><Terminal></Terminal><Card></Card><Address></Address><Transaction></Transaction></CreditCardSale>');
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

        $terminal = $data->Terminal;
        $terminal->TerminalID               = $this->getTerminalID();
        $terminal->CardholderPresentCode    = $this->getCardholderPresentCode();
        $terminal->CardInputCode            = $this->getCardInputCode();
        $terminal->TerminalCapabilityCode   = $this->getTerminalCapabilityCode();
        $terminal->TerminalEnvironmentCode  = $this->getTerminalEnvironmentCode();
        $terminal->CardPresentCode          = $this->getCardPresentCode();
        $terminal->MotoECICode              = $this->getMotoECICode();
        $terminal->CVVPresenceCode          = $this->getCVVPresenceCode();

        $card = $data->Card;
        $card->CardNumber       = $this->getCard()->getNumber();
        $card->ExpirationMonth  = $this->getCard()->getExpiryDate('m');
        $card->ExpirationYear   = $this->getCard()->getExpiryDate('y');
        $card->CVV              = $this->getCard()->getCvv();

        $address = $data->Address;
        $address->BillingName          = $this->getCard()->getCvv();
        $address->BillingAddress1      = $this->getCard()->getBillingAddress1();
        $address->BillingAddress2      = $this->getCard()->getBillingAddress2();
        $address->BillingCity          = $this->getCard()->getBillingCity();
        $address->BillingState         = $this->getCard()->getBillingState();
        $address->BillingZipcode       = $this->getCard()->getBillingPostcode();


        $transaction = $data->Transaction;
        $transaction->TransactionAmount = $this->getAmountInteger();


        // $newOrder = $data->NewOrder;
        // $newOrder->OrbitalConnectionUsername = $this->getUsername();
        // $newOrder->OrbitalConnectionPassword = $this->getPassword();

        // $newOrder->IndustryType = $this->getIndustryType();
        // $newOrder->MessageType = $this->getMessageType();
        // $newOrder->BIN = $this->getBin();
        // $newOrder->MerchantID = $this->getMerchantId();
        // $newOrder->TerminalID = $this->getTerminalId();

        // if ($brand = $this->getCardBrand()) {
        //     $newOrder->CardBrand = $this->getCardBrand();
        // }



        // /** echeck */
        // if ( $this->getBCRtNum() ) {
        //     $newOrder->CurrencyCode = $this->getCurrencyCode();
        //     $newOrder->CurrencyExponent = $this->getCurrencyExponent();
        //     $newOrder->BCRtNum = $this->getBCRtNum();
        //     $newOrder->CheckDDA = $this->getCheckDDA();

        //     if ( $card = $this->getCard() ) {
        //         $newOrder->AVSzip = $card->getBillingPostcode();
        //         $newOrder->AVSaddress1 = $card->getBillingAddress1();
        //         $newOrder->AVSaddress2 = $card->getBillingAddress2();
        //         $newOrder->AVScity = $card->getBillingCity();
        //         $newOrder->AVSstate = $card->getBillingState();
        //         $newOrder->AVSphoneNum = $card->getBillingPhone();
        //         $newOrder->AVSname = $card->getBillingName();
        //         $newOrder->AVScountryCode = $card->getBillingCountry();

        //         $newOrder->AVSDestzip = $card->getShippingPostcode();
        //         $newOrder->AVSDestaddress1 = $card->getShippingAddress1();
        //         $newOrder->AVSDestaddress2 = $card->getShippingAddress2();
        //         $newOrder->AVSDestcity = $card->getShippingCity();
        //         $newOrder->AVSDeststate = $card->getShippingState();
        //         $newOrder->AVSDestphoneNum = $card->getShippingPhone();
        //         $newOrder->AVSDestname = $card->getShippingName();
        //         $newOrder->AVSDestcountryCode = $card->getShippingCountry();
        //     }
        //     unset($newOrder->AccountNum);
        //     unset($newOrder->Exp);
        //     unset($newOrder->CardSecVal);
        // } elseif ($card = $this->getCard()) {
        //     $newOrder->AccountNum = $card->getNumber();
        //     $newOrder->Exp = $card->getExpiryDate('my');
        //     $newOrder->CurrencyCode = $this->getCurrencyCode();
        //     $newOrder->CurrencyExponent = $this->getCurrencyExponent();
        //     $newOrder->CardSecVal = $card->getCvv();

        //     $newOrder->AVSzip = $card->getBillingPostcode();
        //     $newOrder->AVSaddress1 = $card->getBillingAddress1();
        //     $newOrder->AVSaddress2 = $card->getBillingAddress2();
        //     $newOrder->AVScity = $card->getBillingCity();
        //     $newOrder->AVSstate = $card->getBillingState();
        //     $newOrder->AVSphoneNum = $card->getBillingPhone();
        //     $newOrder->AVSname = $card->getBillingName();
        //     $newOrder->AVScountryCode = $card->getBillingCountry();

        //     $newOrder->AVSDestzip = $card->getShippingPostcode();
        //     $newOrder->AVSDestaddress1 = $card->getShippingAddress1();
        //     $newOrder->AVSDestaddress2 = $card->getShippingAddress2();
        //     $newOrder->AVSDestcity = $card->getShippingCity();
        //     $newOrder->AVSDeststate = $card->getShippingState();
        //     $newOrder->AVSDestphoneNum = $card->getShippingPhone();
        //     $newOrder->AVSDestname = $card->getShippingName();
        //     $newOrder->AVSDestcountryCode = $card->getShippingCountry();

        // }




        // $newOrder->OrderID = $this->getOrderId();
        // $newOrder->Amount = $this->getAmountInteger();
        // $newOrder->Comments = $this->getComments();
        // $newOrder->TxRefNum = $this->getTxRefNum();

        return $data;
    }

    public function getData()
    {
        return $this->xmlData()->asXML();
    }

    protected function createResponse($data)
    {
        if ($data->Response) {
            return $this->response = new NewOrderResponse($this, $data);
        } else {
            throw new InvalidResponseException();
        }
    }
}
