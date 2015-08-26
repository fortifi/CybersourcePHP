<?php
/**
 * Created by sam
 * At: 27/05/2014 12:32
 */
namespace CybersourcePHP\Lookups;

class CvCodes
{
  private static $_codes = array(
    "D" => "The transaction was determined to be suspicious by the issuing bank",
    "I" => "The CVN failed the processor's data validation check",
    "M" => "The CVN matched",
    "N" => "The CVN did not match",
    "P" => "The CVN was not processed by the processor for an unspecified reason",
    "S" => "The CVN is on the card but was not included in the request",
    "U" => "Card verification is not supported by the issuing bank",
    "X" => "Card verification is not supported by the card association",
    "1" => "Card verification is not supported for this processor or card type",
    "2" => "An unrecognized result code was returned by the processor for the card verification response",
    "3" => "No result code was returned by the processor"
  );

  public static function lookup($code)
  {
    return isset(self::$_codes[$code]) ? self::$_codes[$code] : false;
  }
} 
