<?php
/**
 * Created by sam
 * At: 27/05/2014 14:29
 */
namespace CybersourcePHP\Structs;

use CybersourcePHP\Lookups\RiskFactorCodes;

class AfsFactorCode
{
  public $code;
  public $description;

  public function __construct($code)
  {
    $this->code = $code;
    $description = RiskFactorCodes::lookup($code);
    if(RiskFactorCodes::lookup($code))
    {
      $this->description = $description;
    }
    else
    {
      $this->description = "Unknown";
    }
  }
} 
