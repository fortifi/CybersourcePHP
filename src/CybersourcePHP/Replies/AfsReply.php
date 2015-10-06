<?php
/**
 * Created by sam
 * At: 20/05/2014 12:33
 */
namespace CybersourcePHP\Replies;

use CybersourcePHP\Structs\AddressInformationCode;
use CybersourcePHP\Structs\AfsFactorCode;
use CybersourcePHP\Structs\DecisionReply;
use CybersourcePHP\Structs\DeviceFingerprint;
use CybersourcePHP\Structs\InternetInformationCode;
use CybersourcePHP\Structs\VelocityCode;

class AfsReply extends BaseReply
{
  public $addressInfoCodes;
  public $afsResult;
  public $afsFactorCodes;
  public $binCountry;
  public $cardIssuer;
  public $cardScheme;
  public $consumerLocalTime;
  public $decision;
  public $decisionReply;
  public $deviceFingerprint;
  public $hostSeverity;
  public $internetInfoCodes;
  public $merchantReferenceCode;
  public $scoreModelUsed;
  public $velocityInfoCodes;

  public function __construct($response)
  {
    parent::__construct($response);
    $this->decision = $response->decision;
    $this->merchantReferenceCode = isset($response->merchantReferenceCode) ? $response->merchantReferenceCode : null;
    if(isset($response->afsReply))
    {
      $this->afsResult = $response->afsReply->afsResult;
      $this->hostSeverity = $response->afsReply->hostSeverity;
      $this->consumerLocalTime = $response->afsReply->consumerLocalTime;
      //AFS Factor Codes
      $this->afsFactorCodes = array();
      foreach(explode($this->_replyDelimiter, $response->afsReply->afsFactorCode) as $factorCode)
      {
        $this->afsFactorCodes[] = new AfsFactorCode($factorCode);
      }
      //Address Information Codes
      $this->addressInfoCodes = array();
      foreach(explode($this->_replyDelimiter, $response->afsReply->addressInfoCode) as $addressInfoCode)
      {
        $this->addressInfoCodes[] = new AddressInformationCode($addressInfoCode);
      }
      //Internet Information Codes
      $this->internetInfoCodes = array();
      foreach(explode($this->_replyDelimiter, $response->afsReply->internetInfoCode) as $internetInfoCode)
      {
        $this->internetInfoCodes[] = new InternetInformationCode($internetInfoCode);
      }
      //Velocity Information Codes
      if(isset($response->afsReply->velocityInfoCode))
      {
        $this->velocityInfoCodes = array();
        foreach(explode($this->_replyDelimiter, $response->afsReply->velocityInfoCode) as $velocityCode)
        {
          $this->velocityInfoCodes[] = new VelocityCode($velocityCode);
        }
      }
      $this->scoreModelUsed = $response->afsReply->scoreModelUsed;
      $this->binCountry = $response->afsReply->binCountry;
      $this->cardScheme = $response->afsReply->cardScheme;
      $this->cardIssuer = $response->afsReply->cardIssuer;
      if(isset($response->decisionReply) && isset($response->decisionReply->velocityInfoCode))
      {
        $this->decisionReply = new DecisionReply(
          $response->decisionReply->casePriority,
          $response->decisionReply->activeProfileReply,
          explode($this->_replyDelimiter, $response->decisionReply->velocityInfoCode)
        );
      }
      if(isset($response->afsReply->deviceFingerprint))
      {
        $this->deviceFingerprint = new DeviceFingerprint();
        $this->deviceFingerprint->cookiesEnabled = $response->afsReply->deviceFingerprint->cookiesEnabled;
        $this->deviceFingerprint->flashEnabled = $response->afsReply->deviceFingerprint->flashEnabled;
        $this->deviceFingerprint->hash = $response->afsReply->deviceFingerprint->hash;
        $this->deviceFingerprint->imagesEnabled = $response->afsReply->deviceFingerprint->imagesEnabled;
        $this->deviceFingerprint->javascriptEnabled = $response->afsReply->deviceFingerprint->javascriptEnabled;
        $this->deviceFingerprint->trueIPAddress = $response->afsReply->deviceFingerprint->trueIPAddress;
        $this->deviceFingerprint->trueIPAddressCity = $response->afsReply->deviceFingerprint->trueIPAddressCity;
        $this->deviceFingerprint->trueIPAddressCountry = $response->afsReply->deviceFingerprint->trueIPAddressCountry;
        $this->deviceFingerprint->smartID = $response->afsReply->deviceFingerprint->smartID;
        $this->deviceFingerprint->smartIDConfidenceLevel = $response->afsReply->deviceFingerprint->smartIDConfidenceLevel;
        $this->deviceFingerprint->screenResolution = $response->afsReply->deviceFingerprint->screenResolution;
        $this->deviceFingerprint->browserLanguage = $response->afsReply->deviceFingerprint->browserLanguage;
      }
    }
  }
} 
