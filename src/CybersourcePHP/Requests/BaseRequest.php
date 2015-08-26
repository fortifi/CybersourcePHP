<?php
/**
 * Created by sam
 * At: 19/05/2014 17:58
 */
namespace CybersourcePHP\Requests;

use CybersourcePHP\Enums\ProductCodes;
use CybersourcePHP\Exceptions\SoapClientException;
use CybersourcePHP\Structs\Item;

class BaseRequest
{
  /** @var \SoapClient $_soapClient */
  protected $_soapClient;
  protected $_replyDelimiter = "^";
  public $merchantID;
  public $merchantReferenceCode;
  public $clientLibrary;
  public $clientLibraryVersion;
  public $clientEnvironment;
  public $purchaseTotals;
  public $item = array();
  public $merchantDefinedData;
  public $deviceFingerprintID;

  public function __construct($merchantID, $reference, $currency = "USD")
  {
    $this->merchantID = $merchantID;
    $this->merchantReferenceCode = $reference;
    $this->clientLibrary = "CybersourcePHP";
    $this->clientLibraryVersion = "1.0";
    $this->clientEnvironment = php_uname();
    $this->purchaseTotals = new \stdClass();
    $this->purchaseTotals->currency = $currency;
    $this->purchaseTotals->grandTotalAmount = 0;
    $this->merchantDefinedData = new \stdClass();
    $this->merchantDefinedData->mddField = array();
  }

  public function setSoapClient(\SoapClient $s)
  {
    $this->_soapClient = $s;
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

  public function getItems()
  {
    return $this->item;
  }

  public function getGrandTotal()
  {
    return $this->purchaseTotals->grandTotalAmount;
  }

  public function addCustomField($id, $value)
  {
    $field = new \stdClass();
    $field->id = $id;
    $field->_ = $value;
    $this->merchantDefinedData->mddField[] = $field;
  }

  public function getCustomFields()
  {
    return $this->merchantDefinedData->mddField;
  }

  public function getIP()
  {
    $headers = array("HTTP_CLIENT_IP", "HTTP_FORWARDED", "HTTP_X_FORWARDED", "HTTP_X_FORWARDED_FOR", "REMOTE_ADDR");
    foreach($headers as $header)
    {
      if(isset($_SERVER[$header]))
      {
        return $_SERVER[$header];
      }
    }
    return "127.0.0.1"; //"0.0.0.0";
  }

  public function run()
  {
    if($this->_soapClient == null)
    {
      throw new SoapClientException("Soap Client is not set");
    }
  }
} 
