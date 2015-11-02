<?php
/**
 * Created by Sam.
 * At: 10/02/15 15:47
 */
namespace CybersourcePHP\Structs;

use CybersourcePHP\Lookups\InternetInformationCodes;

class InternetInformationCode
{
  private $_code;
  private $_description;

  public function __construct($code)
  {
    $this->_code = $code;
    $description = InternetInformationCodes::lookup($code);
    if(InternetInformationCodes::lookup($code))
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
