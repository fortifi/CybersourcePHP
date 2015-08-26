<?php
/**
 * Created by Sam.
 * At: 10/02/15 15:50
 */
namespace CybersourcePHP\Lookups;

class AddressInformationCodes
{
  private static $_codes = array(
    "COR-BA" => "The billing address has corrected elements or can be normalized.",
    "COR-SA" => "The shipping address has corrected elements or can be normalized.",
    "INTL-BA" => "The billing country is outside of the U.S.",
    "INTL-SA" => "The shipping country is outside of the U.S.",
    "MIL-USA" => "The address is a U.S. military address.",
    "MM-A" => "The billing and shipping addresses use different street addresses.",
    "MM-BIN" => "The card BIN (the first six digits of the number) does not match the country.",
    "MM-C" => "The billing and shipping addresses use different cities.",
    "MM-CO" => "The billing and shipping addresses use different countries.",
    "MM-ST" => "The billing and shipping addresses use different states.",
    "MM-Z" => "The billing and shipping addresses use different postal codes.",
    "UNV-ADDR" => "The address is unverifiable."
  );

  public static function lookup($code)
  {
    return isset(self::$_codes[$code]) ? self::$_codes[$code] : false;
  }
}
