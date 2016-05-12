<?php
/**
 * Created by sam
 * At: 20/05/2014 12:33
 */
namespace CybersourcePHP\Replies;

use CybersourcePHP\Structs\AddressInformationCode;
use CybersourcePHP\Structs\AfsFactorCode;
use CybersourcePHP\Structs\DeviceFingerprint;
use CybersourcePHP\Structs\InternetInformationCode;

class AfsReply
{
  private $_addressInfoCodes;
  private $_afsFactorCodes;
  private $_afsResult;
  private $_binCountry;
  private $_cardIssuer;
  private $_cardScheme;
  private $_consumerLocalTime;
  private $_hostSeverity;
  private $_internetInfoCodes;
  private $_scoreModelUsed;

  public function __construct($afsReply, $delimiter)
  {
    //Address Information Codes
    $this->_addressInfoCodes = array();
    if(isset($afsReply->addressInfoCode))
    {
      foreach(explode($delimiter, $afsReply->addressInfoCode) as $addressInfoCode)
      {
        if($addressInfoCode != "")
        {
          $this->_addressInfoCodes[] = new AddressInformationCode($addressInfoCode);
        }
      }
    }
    //AFS Factor Codes
    $this->_afsFactorCodes = array();
    if(isset($afsReply->afsFactorCode))
    {
      foreach(explode($delimiter, $afsReply->afsFactorCode) as $factorCode)
      {
        if($factorCode != "")
        {
          $this->_afsFactorCodes[] = new AfsFactorCode($factorCode);
        }
      }
    }
    $this->_afsResult = isset($afsReply->afsResult) ? $afsReply->afsResult : "";
    $this->_binCountry = isset($afsReply->binCountry) ? $afsReply->binCountry : "";
    $this->_cardScheme = isset($afsReply->cardScheme) ? $afsReply->cardScheme : "";
    $this->_cardIssuer = isset($afsReply->cardIssuer) ? $afsReply->cardIssuer : "";
    $this->_consumerLocalTime = $afsReply->consumerLocalTime;
    if(isset($afsReply->deviceFingerprint))
    {
      $this->_deviceFingerprint = new DeviceFingerprint($afsReply->deviceFingerprint);
    }
    $this->_hostSeverity = isset($afsReply->hostSeverity) ? $afsReply->hostSeverity : "";
    //Internet Information Codes
    $this->_internetInfoCodes = array();
    if(isset($afsReply->internetInfoCode))
    {
      foreach(explode($delimiter, $afsReply->internetInfoCode) as $internetInfoCode)
      {
        if($internetInfoCode != "")
        {
          $this->_internetInfoCodes[] = new InternetInformationCode($internetInfoCode);
        }
      }
    }
    $this->_scoreModelUsed = isset($afsReply->scoreModelUsed) ? $afsReply->scoreModelUsed : "";
  }

  public function getAddressInfoCodes()
  {
    return $this->_addressInfoCodes;
  }

  public function getAfsFactorCodes()
  {
    return $this->_afsFactorCodes;
  }

  public function getAfsResult()
  {
    return $this->_afsResult;
  }

  public function getBinCountry()
  {
    return $this->_binCountry;
  }

  public function getCardIssuer()
  {
    return $this->_cardIssuer;
  }

  public function getCardScheme()
  {
    return $this->_cardScheme;
  }

  public function getConsumerLocalTime()
  {
    return $this->_consumerLocalTime;
  }

  public function getHostSeverity()
  {
    return $this->_hostSeverity;
  }

  public function getInternetInfoCodes()
  {
    return $this->_internetInfoCodes;
  }

  public function getScoreModelUsed()
  {
    return $this->_scoreModelUsed;
  }
}
