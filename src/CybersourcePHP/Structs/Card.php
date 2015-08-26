<?php
/**
 * Created by sam
 * At: 19/05/2014 18:19
 */
namespace CybersourcePHP\Structs;

class Card
{
  public $accountNumber;
  public $expirationMonth;
  public $expirationYear;
  public $cardType;

  public function __construct($number, $month, $year, $type)
  {
    $this->accountNumber = $number;
    $this->expirationMonth = $month;
    $this->expirationYear = $year;
    $this->cardType = $type;
  }
} 
