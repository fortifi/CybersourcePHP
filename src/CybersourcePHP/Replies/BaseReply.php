<?php
/**
 * Created by sam
 * At: 20/05/2014 12:33
 */
namespace CybersourcePHP\Replies;

class BaseReply
{
  public $merchantReferenceCode;
  public $requestID;
  public $decision;
  public $reasonCode;
  public $requestToken;

  public function __construct($reference, $requestID, $decision, $reasonCode, $token)
  {
    $this->merchantReferenceCode = $reference;
    $this->requestID = $requestID;
    $this->decision = $decision;
    $this->reasonCode = $reasonCode;
    $this->requestToken = $token;
  }
} 
