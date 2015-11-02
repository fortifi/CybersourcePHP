<?php
/**
 * Created by Sam.
 * At: 10/02/15 15:51
 */
namespace CybersourcePHP\Structs;

use CybersourcePHP\Lookups\AddressInformationCodes;

class AddressInformationCode
{
  private $_code;
  private $_description;

  public function __construct($code)
  {
    $this->_code = $code;
    $description = AddressInformationCodes::lookup($code);
    if(AddressInformationCodes::lookup($code))
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
