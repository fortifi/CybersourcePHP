<?php
/**
 * Created by Sam.
 * At: 06/10/2015 17:20
 */
namespace CybersourcePHP\Requests;

use CybersourcePHP\Exceptions\CaseManagementActionException;
use CybersourcePHP\Replies\BaseReply;

class CaseManagementActionRequest extends BaseRequest
{
  public $caseManagementActionService;

  public function __construct($merchantId, $reference)
  {
    parent::__construct($merchantId, $reference);
    $this->caseManagementActionService = new \stdClass();
    $this->caseManagementActionService->run = "true";
  }

  public function setActionCode($actionCode)
  {
    $this->caseManagementActionService->actionCode = $actionCode;
  }

  public function setRequestId($requestId)
  {
    $this->caseManagementActionService->requestID = $requestId;
  }

  //The magic
  public function run()
  {
    if(!isset($this->caseManagementActionService->actionCode) || !isset($this->caseManagementActionService->requestID))
    {
      throw new CaseManagementActionException("Required fields are not set");
    }
    parent::run();
    $result = $this->_soapClient->runTransaction($this);
    return new BaseReply($result);
  }
}
