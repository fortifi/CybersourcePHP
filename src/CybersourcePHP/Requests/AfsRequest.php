<?php
/**
 * Created by sam
 * At: 19/05/2014 18:15
 */
namespace CybersourcePHP\Requests;

use CybersourcePHP\Enums\CardType;
use CybersourcePHP\Enums\ProductCodes;
use CybersourcePHP\Exceptions\AfsException;
use CybersourcePHP\Lookups\AvsCodes;
use CybersourcePHP\Lookups\CvCodes;
use CybersourcePHP\Lookups\States;
use CybersourcePHP\Replies\BaseReply;
use CybersourcePHP\Structs\BillTo;
use CybersourcePHP\Structs\Card;
use CybersourcePHP\Structs\Item;

class AfsRequest extends BaseRequest
{
  public $afsService;
  public $billTo;
  public $card;
  public $item = array();
  public $merchantDefinedData;
  public $purchaseTotals;

  protected $_transactionType;

  public function __construct($merchantID, $reference, $currency = "USD")
  {
    parent::__construct($merchantID, $reference);
    $this->afsService = new \stdClass();
    $this->afsService->run = "true";
    $this->billTo = new BillTo();
    $this->merchantDefinedData = new \stdClass();
    $this->merchantDefinedData->mddField = array();
    $this->purchaseTotals = new \stdClass();
    $this->purchaseTotals->currency = $currency;
    $this->purchaseTotals->grandTotalAmount = 0;
    $this->_transactionType = "CC";
  }

  public function addItem($price, $quantity, $productCode = ProductCodes::_default, $productName = "", $productSKU = "")
  {
    $item = new Item();
    $item->id = count($this->item);
    $item->unitPrice = $price;
    $item->quantity = $quantity;
    $item->productCode = $productCode;
    $item->productName = $productName;
    $item->productSKU = $productSKU;
    $this->item[] = $item;
    $this->purchaseTotals->grandTotalAmount += ($price * $quantity);
  }


  public function getCard()
  {
    return isset($this->card) ? $this->card : null;
  }

  public function getItems()
  {
    return $this->item;
  }

  public function getGrandTotal()
  {
    return $this->purchaseTotals->grandTotalAmount;
  }

  public function getPreauthCodes()
  {
    if(!isset($this->afsService->avsCode) || !isset($this->afsService->cvCode))
    {
      return null;
    }
    return array("avs" => $this->afsService->avsCode, "cv" => $this->afsService->cvCode);
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
        //Can't find the state?
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

  public function setCard($number, $month, $year, $type = CardType::AUTO)
  {
    $card = new Card($number, $month, $year, $type);
    $this->card = $card;
  }

  public function setCardObj(Card $card)
  {
    $this->card = $card;
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

  //The magic
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
    return new BaseReply($result);
  }
} 
