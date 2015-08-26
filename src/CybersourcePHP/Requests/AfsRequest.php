<?php
/**
 * Created by sam
 * At: 19/05/2014 18:15
 */
namespace CybersourcePHP\Requests;

use CybersourcePHP\Enums\CardType;
use CybersourcePHP\Exceptions\AfsException;
use CybersourcePHP\Lookups\AvsCodes;
use CybersourcePHP\Lookups\CvCodes;
use CybersourcePHP\Lookups\ReasonCodes;
use CybersourcePHP\Lookups\States;
use CybersourcePHP\Replies\AfsReply;
use CybersourcePHP\Structs\AddressInformationCode;
use CybersourcePHP\Structs\DecisionReply;
use CybersourcePHP\Structs\AfsFactorCode;
use CybersourcePHP\Structs\BillTo;
use CybersourcePHP\Structs\Card;
use CybersourcePHP\Structs\DeviceFingerprint;
use CybersourcePHP\Structs\InternetInformationCode;
use CybersourcePHP\Structs\VelocityCode;

class AfsRequest extends BaseRequest
{
  public $afsService;
  public $billTo;
  public $card;
  protected $_transactionType;

  public function __construct($merchantID, $reference, $currency = "USD")
  {
    parent::__construct($merchantID, $reference, $currency);
    $this->afsService = new \stdClass();
    $this->afsService->run = "true";
    $this->billTo = new BillTo();
    $this->_transactionType = "CC";
  }

  public function getTransactionType()
  {
    return isset($this->_transactionType) ? $this->_transactionType : "";
  }

  public function setTransactionType($type)
  {
    if($type != "CC" && $type != "PP")
    {
      $type = "CC";
    }
    $this->_transactionType = $type;
  }

  public function getUserDetails()
  {
    return isset($this->billTo) ? $this->billTo : null;
  }

  public function setUserDetails($first, $last, $email, $phone, $customerID = null, $ip = null)
  {
    $this->billTo->firstName = $first;
    $this->billTo->lastName = $last;
    $this->billTo->email = $email;
    $phone = preg_replace("/[^\d]/", "", $phone); //Make numeric
    if(strlen($phone) < 7) //Min 7 digits
    {
      $phone = "";
    }
    $phone = substr($phone, 0, 15); //Max 15 digits
    $this->billTo->phoneNumber = $phone;
    $this->billTo->customerID = $customerID;
    $this->billTo->ipAddress = ($ip == null) ? $this->getIP() : $ip;
  }

  public function setAddress($street, $city, $state, $country, $postcode)
  {
    $this->billTo->street1 = $street;
    $this->billTo->city = $city;
    $countryCode = strtoupper($country);
    //For US and CA, the state must be the two character code, so translate it if necessary
    if($countryCode == "US" || $countryCode == "CA")
    {
      $stateInfo = States::getState($state);
      if($stateInfo != null)
      {
        $this->billTo->state = $stateInfo->stateCode;
      }
      else
      {
        //Probably malformed or mis-spelt
        $this->billTo->state = $state;
      }
    }
    else
    {
      $this->billTo->state = $state;
    }
    $this->billTo->country = $country;
    //Prefix 4 digit or less zip codes with 0
    if($countryCode == "US")
    {
      while(strlen($postcode) < 5)
      {
        $postcode = "0" . $postcode;
      }
    }
    $this->billTo->postalCode = $postcode;
  }

  public function getCard()
  {
    return isset($this->card) ? $this->card : null;
  }

  public function setCard($number, $month, $year, $type = CardType::AUTO)
  {
    $card = new Card($number, $month, $year, $type);
    $this->card = $card;
  }

  public function setCardObj(Card $card)
  {
    $this->card = $card;
  }

  public function getPreauthCodes()
  {
    if(!isset($this->afsService->avsCode) || !isset($this->afsService->cvCode))
    {
      return null;
    }
    return array("avs" => $this->afsService->avsCode, "cv" => $this->afsService->cvCode);
  }

  public function setPreauthCodes($avs, $cv)
  {
    if(!AvsCodes::lookup($avs))
    {
      throw new AfsException("Invalid AVS value");
    }
    if(!CvCodes::lookup($cv))
    {
      throw new AfsException("Invalid CV value");
    }
    $this->afsService->avsCode = $avs;
    $this->afsService->cvCode = $cv;
  }

  public function run()
  {
    if($this->billTo == null || !isset($this->billTo->firstName) || !isset($this->billTo->street1))
    {
      throw new AfsException("Billing information is not set");
    }
    if($this->card == null && $this->_transactionType == "CC")
    {
      throw new AfsException("Card information is not set");
    }
    parent::run();
    $result = $this->_soapClient->runTransaction($this);
    $merchantReferenceCode = isset($result->merchantReferenceCode) ? $result->merchantReferenceCode : null;
    $reply = new AfsReply($merchantReferenceCode, $result->requestID, $result->decision, $result->reasonCode, $result->requestToken);
    //Check for errors
    $reply->error = false;
    if($result->reasonCode != "100")
    {
      $reply->error = ReasonCodes::lookup($result->reasonCode);
      if($result->reasonCode == "101") //Missing field(s)
      {
        $fields = (array)$result->missingField;
        foreach($fields as $field)
        {
          $reply->error .= $field . ",";
        }
      }
      if($result->reasonCode == "102") //Invalid field(s)
      {
        $fields = (array)$result->invalidField;
        foreach($fields as $field)
        {
          $reply->error .= $field . ",";
        }
      }
    }
    if(isset($result->afsReply))
    {
      $reply->afsResult = $result->afsReply->afsResult;
      $reply->hostSeverity = $result->afsReply->hostSeverity;
      $reply->consumerLocalTime = $result->afsReply->consumerLocalTime;
      //AFS Factor Codes
      $reply->afsFactorCodes = array();
      foreach(explode($this->_replyDelimiter, $result->afsReply->afsFactorCode) as $factorCode)
      {
        $reply->afsFactorCodes[] = new AfsFactorCode($factorCode);
      }
      //Address Information Codes
      $reply->addressInfoCodes = array();
      foreach(explode($this->_replyDelimiter, $result->afsReply->addressInfoCode) as $addressInfoCode)
      {
        $reply->addressInfoCodes[] = new AddressInformationCode($addressInfoCode);
      }
      //Internet Information Codes
      $reply->internetInfoCodes = array();
      foreach(explode($this->_replyDelimiter, $result->afsReply->internetInfoCode) as $internetInfoCode)
      {
        $reply->internetInfoCodes[] = new InternetInformationCode($internetInfoCode);
      }
      //Velocity Information Codes
      if(isset($result->afsReply->velocityInfoCode))
      {
        $reply->velocityInfoCodes = array();
        foreach(explode($this->_replyDelimiter, $result->afsReply->velocityInfoCode) as $velocityCode)
        {
          $reply->velocityInfoCodes[] = new VelocityCode($velocityCode);
        }
      }
      $reply->scoreModelUsed = $result->afsReply->scoreModelUsed;
      $reply->binCountry = $result->afsReply->binCountry;
      $reply->cardScheme = $result->afsReply->cardScheme;
      $reply->cardIssuer = $result->afsReply->cardIssuer;
      if(isset($result->decisionReply))
      {
        $reply->decisionReply = new DecisionReply(
          $result->decisionReply->casePriority,
          $result->decisionReply->activeProfileReply,
          explode($this->_replyDelimiter, $result->decisionReply->velocityInfoCode)
        );
      }
      if(isset($result->afsReply->deviceFingerprint))
      {
        $reply->deviceFingerprint = new DeviceFingerprint();
        $reply->deviceFingerprint->cookiesEnabled = $result->afsReply->deviceFingerprint->cookiesEnabled;
        $reply->deviceFingerprint->flashEnabled = $result->afsReply->deviceFingerprint->flashEnabled;
        $reply->deviceFingerprint->hash = $result->afsReply->deviceFingerprint->hash;
        $reply->deviceFingerprint->imagesEnabled = $result->afsReply->deviceFingerprint->imagesEnabled;
        $reply->deviceFingerprint->javascriptEnabled = $result->afsReply->deviceFingerprint->javascriptEnabled;
        $reply->deviceFingerprint->trueIPAddress = $result->afsReply->deviceFingerprint->trueIPAddress;
        $reply->deviceFingerprint->trueIPAddressCity = $result->afsReply->deviceFingerprint->trueIPAddressCity;
        $reply->deviceFingerprint->trueIPAddressCountry = $result->afsReply->deviceFingerprint->trueIPAddressCountry;
        $reply->deviceFingerprint->smartID = $result->afsReply->deviceFingerprint->smartID;
        $reply->deviceFingerprint->smartIDConfidenceLevel = $result->afsReply->deviceFingerprint->smartIDConfidenceLevel;
        $reply->deviceFingerprint->screenResolution = $result->afsReply->deviceFingerprint->screenResolution;
        $reply->deviceFingerprint->browserLanguage = $result->afsReply->deviceFingerprint->browserLanguage;
      }
    }
    return $reply;
  }
} 
