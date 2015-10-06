<?php
/**
 * Created by sam
 * At: 20/05/2014 12:33
 */
namespace CybersourcePHP\Replies;

use CybersourcePHP\Lookups\ReasonCodes;

class BaseReply
{
  public $error;
  public $reasonCode;
  public $requestID;
  public $requestToken;
  protected $_rawResponse;
  protected $_replyDelimiter = "^";

  public function __construct($response)
  {
    $this->_rawResponse = $response;
    $this->requestID = $response->requestID;
    $this->requestToken = $response->requestToken;
    //Check for errors
    $this->error = false;
    $this->reasonCode = $response->reasonCode;
    if($response->reasonCode != "100")
    {
      $this->error = ReasonCodes::lookup($response->reasonCode) . " ";
      if($response->reasonCode == "101") //Missing field(s)
      {
        $fields = (array)$response->missingField;
        foreach($fields as $field)
        {
          $this->error .= $field . ",";
        }
      }
      if($response->reasonCode == "102") //Invalid field(s)
      {
        $fields = (array)$response->invalidField;
        foreach($fields as $field)
        {
          $this->error .= $field . ",";
        }
      }
    }
  }

  public function getRaw()
  {
    return $this->_rawResponse;
  }
} 
