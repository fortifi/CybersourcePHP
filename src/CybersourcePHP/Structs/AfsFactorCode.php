<?php
/**
 * Created by sam
 * At: 27/05/2014 14:29
 */
namespace CybersourcePHP\Structs;

use CybersourcePHP\Lookups\RiskFactorCodes;

class AfsFactorCode
{
  private $_code;
  private $_description;

  public function __construct($code)
  {
    $this->_code = $code;
    $description = RiskFactorCodes::lookup($code);
    if(RiskFactorCodes::lookup($code))
    {
      $this->_description = $description;
    }
    else
    {
      $this->_description = "Unknown";
    }
  }

  public function getCode()
  {
    return $this->_code;
  }

  public function getDescription()
  {
    return $this->_description;
  }
} 
