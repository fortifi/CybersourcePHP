<?php
/**
 * Created by Sam.
 * At: 26/08/15 15:22
 */
//If not using composer:
include_once(dirname(__FILE__) . "/../../../vendor/autoload.php");
$config = new \CybersourcePHP\Structs\Configuration(
  "YOUR_MERCHANT_ID",
  "YOUR_API_KEY",
  "YOUR_ORG_ID"
);
//If you want test mode, uncomment this:
//$config->setWSDL("https://ics2wstest.ic3.com/commerce/1.x/transactionProcessor/CyberSourceTransaction_1.99.wsdl");
$client = new \CybersourcePHP\CybersourceClient($config);
$afs = $client->afsRequest();
$afs->setUserDetails("John", "Smith", "john@smith.com", "07000000000");
$afs->setAddress("123 First Street", "London", "London", "GB", "LO123ND");
$afs->setCardObj(\CybersourcePHP\Lookups\TestCards::Visa());
$afs->setPreauthCodes("P", "M");
$afs->addItem("99.95", 1, \CybersourcePHP\Enums\ProductCodes::Service, "Consultancy", "CONS_1H");
//See Docs/Fingerprint.txt for more details on device fingerprinting
$afs->deviceFingerprintID = "PHPCYB_1234567890";
//This can throw AFSException, so this should be handled
$response = $afs->run();
//Response will be an instance of AFSReply
var_dump($response);
