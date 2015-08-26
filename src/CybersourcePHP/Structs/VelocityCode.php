<?php
/**
 * Created by Sam.
 * At: 10/02/15 15:29
 */
namespace CybersourcePHP\Structs;

use CybersourcePHP\Lookups\VelocityCodes;

class VelocityCode
{
  public $code;
  public $description;

  public function __construct($code)
  {
    $this->code = $code;
    $description = VelocityCodes::lookup($code);
    if(VelocityCodes::lookup($code))
    {
      $this->description = $description;
    }
    else
    {
      $this->description = "Unknown";
    }
  }
}
