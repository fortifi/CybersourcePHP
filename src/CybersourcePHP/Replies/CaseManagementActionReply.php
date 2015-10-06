<?php
/**
 * Created by Sam.
 * At: 06/10/2015 17:14
 */
namespace CybersourcePHP\Replies;

class CaseManagementActionReply extends BaseReply
{
  public $code;

  public function __construct($response)
  {
    parent::__construct($response);
    $this->code = isset($response->caseManagementActionReply) ?  $response->caseManagementActionReply->reasonCode : -1;
  }
}
