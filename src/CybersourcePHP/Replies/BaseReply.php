<?php
/**
 * Created by sam
 * At: 20/05/2014 12:33
 */
namespace CybersourcePHP\Replies;

use CybersourcePHP\Lookups\ReasonCodes;

class BaseReply
{
  private $_decision;
  private $_error = false;
  private $_merchantReferenceCode;
  private $_reasonCode;
  private $_requestID;
  private $_requestToken;
  protected $_rawResponse;
  protected $_replyDelimiter = "^";

  public function __construct($response)
  {
    $this->_decision = isset($response->decision) ? $response->decision : "UNKNOWN";
    $this->_merchantReferenceCode = isset($response->merchantReferenceCode) ? $response->merchantReferenceCode : "UNKNOWN";
    $this->_rawResponse = $response;
    $this->_reasonCode = $response->reasonCode;
    $this->_requestID = $response->requestID;
    $this->_requestToken = $response->requestToken;
    if($this->successfulTransaction())
    {
      if(isset($response->afsReply))
      {
        $this->afsReply = new AfsReply($response->afsReply, $this->_replyDelimiter);
      }
      if(isset($this->caseManagementActionReply))
      {
        $this->caseManagementActionReply = new CaseManagementActionReply($response->caseManagementActionReply);
      }
      if(isset($response->decisionReply))
      {
        $this->decisionReply = new DecisionReply($response->decisionReply, $this->_replyDelimiter);
      }
    }
    else
    {
      $this->_decision = "UNKNOWN";
      $this->_error = ReasonCodes::lookup($response->reasonCode) . " ";
      if($response->reasonCode == "101") //Missing field(s)
      {
        $fields = (array)$response->missingField;
        foreach($fields as $field)
        {
          $this->_error .= $field . ",";
        }
      }
      if($response->reasonCode == "102") //Invalid field(s)
      {
        $fields = (array)$response->invalidField;
        foreach($fields as $field)
        {
          $this->_error .= $field . ",";
        }
      }
    }
  }

  public function getAFSReply()
  {
    return isset($this->afsReply) ? $this->afsReply : false;
  }

  public function getCaseManagementActionReply()
  {
    return isset($this->caseManagementActionReply) ? $this->caseManagementActionReply : false;
  }

  public function getDecision()
  {
    return $this->_decision;
  }

  public function getDecisionReply()
  {
    return isset($this->decisionReply) ? $this->decisionReply : false;
  }

  public function getError()
  {
    return $this->_error;
  }

  public function getMerchantReferenceCode()
  {
    return $this->_merchantReferenceCode;
  }

  public function getRaw()
  {
    return $this->_rawResponse;
  }

  public function getReasonCode()
  {
    return $this->_reasonCode;
  }

  public function getRequestID()
  {
    return $this->_requestID;
  }

  public function getRequestToken()
  {
    return $this->_requestToken;
  }

  public function hasAFS()
  {
    return isset($this->afsReply) && $this->afsReply instanceof AFSReply;
  }

  public function hasCaseManagementAction()
  {
    return isset($this->caseManagementActionReply) && $this->caseManagementActionReply instanceof CaseManagementActionReply;
  }

  public function hasDecisionReply()
  {
    return isset($this->decisionReply) && $this->decisionReply instanceof DecisionReply;
  }

  public function successfulTransaction()
  {
    $errorCodes = array("101", "102", "150", "151", "152");
    foreach($errorCodes as $errorCode)
    {
      if($this->_reasonCode == $errorCode)
      {
        return false;
      }
    }
    return true;
  }
} 
