<?php
/**
 * Created by sam
 * At: 20/05/2014 11:21
 */

namespace CybersourcePHP\Lookups;

use CybersourcePHP\Enums\CardType;
use CybersourcePHP\Structs\Card;

class TestCards
{
  public static function Visa()
  {
    return new Card("4111111111111111", "12", date("Y") + 10, CardType::Visa);
  }

  public static function MasterCard()
  {
    return new Card("5555555555554444", "12", date("Y") + 10, CardType::MasterCard);
  }

  public static function AmEx()
  {
    return new Card("378282246310005", "12", date("Y") + 10, CardType::AmEx);
  }
} 
