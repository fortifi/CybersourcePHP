<?php
/**
 * Created by Sam.
 * At: 26/08/15 15:05
 */
namespace CybersourcePHP\Structs;

class Configuration
{
  public $merchantID;
  public $apiKey;
  public $orgID;
  //Probably don't need to change these
  public $wsdl = "https://ics2ws.ic3.com/commerce/1.x/transactionProcessor/CyberSourceTransaction_1.99.wsdl";
  public $wsdlTest = "https://ics2wstest.ic3.com/commerce/1.x/transactionProcessor/CyberSourceTransaction_1.99.wsdl";
  public $wsseNS = "http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd";
  public $typeNS = "http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText";

  public function __construct($merchantID, $apiKey, $orgID)
  {
    $this->merchantID = $merchantID;
    $this->apiKey = $apiKey;
    $this->orgID = $orgID;
  }

  public function setWSDL($wsdl)
  {
    $this->wsdl = $wsdl;
  }

  public function setNamespaces($wsse, $type)
  {
    $this->wsseNS = $wsse;
    $this->typeNS = $type;
  }
}
