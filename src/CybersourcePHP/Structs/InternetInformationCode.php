<?php
/**
 * Created by Sam.
 * At: 10/02/15 15:47
 */
namespace CybersourcePHP\Structs;

use CybersourcePHP\Lookups\InternetInformationCodes;

class InternetInformationCode
{
  public $code;
  public $description;

  public function __construct($code)
  {
    $this->code = $code;
    $description = InternetInformationCodes::lookup($code);
    if(InternetInformationCodes::lookup($code))
    {
      $this->description = $description;
    }
    else
    {
      $this->description = "Unknown";
    }
  }
}
