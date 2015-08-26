<?php
/**
 * Created by sam
 * At: 06/06/2014 17:06
 */
namespace CybersourcePHP\Structs;

class StateInfo
{
  public $stateCode;
  public $stateName;

  public function __construct($code, $name)
  {
    $this->stateCode = $code;
    $this->stateName = $name;
  }
} 
