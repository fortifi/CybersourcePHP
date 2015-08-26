<?php
/**
 * Created by Sam.
 * At: 05/03/15 12:00
 */
namespace CybersourcePHP\Lookups;

class ReasonCodes
{
  private static $_codes = array(
    "100" => "Successful transaction",
    "101" => "The request is missing one or more required fields.",
    "102" => "One or more fields in the request contains invalid data.",
    "150" => "Error: General system failure.",
    "151" => "Error: The request was received but there was a server time-out. This error does not include time-outs between the client and the server.",
    "152" => "Error: The request was received but there was a service time-out.",
    "202" => "CyberSource declined the request because the card has expired. You may also receive this reason code if the expiration date that you provided does not match the date on file at the issuing bank. If the payment processor allows issuance of credits to expired cards, CyberSource does not limit this functionality.",
    "231" => "The account number is invalid.",
    "234" => "There is a problem with your CyberSource merchant configuration.",
    "400" => "The fraud score exceeds your threshold.",
    "480" => "The order is marked for review by Decision Manager.",
    "481" => "The order is rejected by Decision Manager."
  );

  public static function lookup($code)
  {
    return isset(self::$_codes[$code]) ? self::$_codes[$code] : false;
  }
}
