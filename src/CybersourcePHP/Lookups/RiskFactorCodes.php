<?php
/**
 * Created by sam
 * At: 27/05/2014 14:03
 */
namespace CybersourcePHP\Lookups;

class RiskFactorCodes
{
  private static $_codes = array(
    "A" => "Excessive address change. The customer changed the billing address two or more times in the last six months",
    "B" => "Card BIN or authorization risk. Risk factors are related to credit card BIN and/or card authorization checks",
    "C" => "High number of account numbers. The customer used more than six credit cards numbers in the last six months",
    "D" => "Email address impact. The customer uses a free email provider, or the email address is risky.",
    "E" => "Positive list. The customer is on your positive list",
    "F" => "Negative list. The account number, street address, email address, or IP address for this order appears on your negative list",
    "G" => "Geolocation inconsistencies. The customer’s email domain, phone number, billing address, shipping address, or IP address is suspicious",
    "H" => "Excessive name changes. The customer changed the name two or more times in the last six months",
    "I" => "Internet inconsistencies. The IP address and email domain are not consistent with the billing address",
    "N" => "Nonsensical input. The customer name and address fields contain meaningless words or language",
    "O" => "Obscenities. The customer’s input contains obscene words",
    "P" => "Identity morphing. Multiple values of an identity element are linked to a value of a different identity element. For example, multiple phone numbers are linked to a single account number",
    "Q" => "Phone inconsistencies. The customer’s phone number is suspicious",
    "R" => "Risky order. The transaction, customer, and merchant information show multiple high-risk correlations",
    "T" => "Time hedge. The customer is attempting a purchase outside of the expected hours",
    "U" => "Unverifiable address. The billing or shipping address cannot be verified",
    "V" => "Velocity. The account number was used many times in the past 15 minutes",
    "W" => "Marked as suspect. The billing or shipping address is similar to an address previously marked as suspect",
    "Y" => "Gift Order. The street address, city, state, or country of the billing and shipping addresses do not correlate",
    "Z" => "Invalid value. Because the request contains an unexpected value, a default value was substituted. Although the transaction can still be processed, examine the request carefully for abnormalities in the order"
  );

  public static function lookup($code)
  {
    return isset(self::$_codes[$code]) ? self::$_codes[$code] : false;
  }
} 
