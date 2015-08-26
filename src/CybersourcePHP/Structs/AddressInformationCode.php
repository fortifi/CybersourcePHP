<?php
/**
 * Created by Sam.
 * At: 10/02/15 15:51
 */
namespace CybersourcePHP\Structs;

use CybersourcePHP\Lookups\AddressInformationCodes;

class AddressInformationCode
{
  public $code;
  public $description;

  public function __construct($code)
  {
    $this->code = $code;
    $description = AddressInformationCodes::lookup($code);
    if(AddressInformationCodes::lookup($code))
    {
      $this->description = $description;
    }
    else
    {
      $this->description = "Unknown";
    }
  }
}
