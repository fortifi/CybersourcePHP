<?php
/**
 * Created by Sam.
 * At: 06/10/2015 17:14
 */
namespace CybersourcePHP\Replies;

class CaseManagementActionReply
{
  private $_reasonCode;

  public function __construct($caseManagementActionReply)
  {
    $this->_reasonCode = isset($caseManagementActionReply->reasonCode) ? $caseManagementActionReply->reasonCode : -1;
  }

  public function getReasonCode()
  {
    return $this->_reasonCode;
  }
}
