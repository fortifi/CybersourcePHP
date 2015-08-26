<?php
/**
 * Created by sam
 * At: 27/05/2014 12:05
 */
namespace CybersourcePHP\Lookups;

class AvsCodes
{
  private static $_codes = array(
    "A" => "Partial match: street address matches, but 5-digit and 9-digit postal codes do not match",
    "B" => "Partial match: street address matches, but postal code is not verified",
    "C" => "No match: street address and postal code do not match",
    "D" => "Match: street address and postal code match",
    "E" => "Invalid: AVS data is invalid or AVS is not allowed for this card type",
    "F" => "Partial match: card member’s name does not match, but billing postal code matches",
    "G" => "Not supported: non-U.S. issuing bank does not support AVS",
    "H" => "Partial match: card member’s name does not match, but street address and postal code match",
    "I" => "No match: address not verified",
    "K" => "Partial match: card member’s name matches, but billing address and billing postal code do not match",
    "L" => "Partial match: card member’s name and billing postal code match, but billing address does not match",
    "M" => "Match: street address and postal code match",
    "N" => "No match: one of the following: Street address and postal code do not match or Card member’s name, street address, and postal code do not match",
    "O" => "Partial match: card member’s name and billing address match, but billing postal code does not match",
    "P" => "Partial match: postal code matches, but street address not verified",
    "R" => "System unavailable",
    "S" => "Not supported: U.S.-issuing bank does not support AVS",
    "T" => "Partial match: card member’s name does not match, but street address matches",
    "U" => "System unavailable: address information unavailable for one of these reasons: The U.S. bank does not support non-U.S. AVS or The AVS in a U.S. bank is not functioning properly",
    "V" => "Match: card member’s name, billing address, and billing postal code match",
    "W" => "Partial match: street address does not match, but 9-digit postal code matches",
    "X" => "Match: street address and 9-digit postal code match",
    "Y" => "Match: street address and 5-digit postal code match",
    "Z" => "Partial match: street address does not match, but 5-digit postal code matches",
    "1" => "Not supported: AVS is not supported for this processor or card type",
    "2" => "Unrecognized: the processor returned an unrecognized value for the AVS response",
    "3" => "Match: address is confirmed",
    "4" => "No match: address is not confirmed"
  );

  public static function lookup($code)
  {
    return isset(self::$_codes[$code]) ? self::$_codes[$code] : false;
  }
} 
