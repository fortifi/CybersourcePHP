<?php
/**
 * Created by Sam.
 * At: 10/02/15 15:43
 */
namespace CybersourcePHP\Lookups;

class InternetInformationCodes
{
  private static $_codes = array(
    "FREE-EM" => "The customer’s email address is from a free email provider.",
    "INTL-IPCO" => "The country of the customer’s IP address is outside of the U.S.",
    "INV-EM" => "The customer’s email address is invalid.",
    "MM-EMBCO" => "The domain in the customer’s email address is not consistent with the country in the billing address.",
    "MM-IPBC" => "The customer’s IP address is not consistent with the city in the billing address.",
    "MM-IPBCO" => "The customer’s IP address is not consistent with the country in the billing address.",
    "MM-IPBST" => "The customer’s IP address is not consistent with the state in the billing address. However, this information code may not be returned when the inconsistency is between immediately adjacent states.",
    "MM-IPEM" => "The customer’s email address is not consistent with the customer’s IP address.",
    "RISK-EM" => "The customer's email domain (for example, mail.example.com) is associated with higher risk.",
    "UNV-NID" => "The customer’s IP address is from an anonymous proxy. These entities completely hide the IP information.",
    "UNV-RISK" => "The IP address is from a risky source.",
    "UNV-EMBCO" => "The country of the customer’s email address does not match the country in the billing address."
  );

  public static function lookup($code)
  {
    return isset(self::$_codes[$code]) ? self::$_codes[$code] : false;
  }
}
