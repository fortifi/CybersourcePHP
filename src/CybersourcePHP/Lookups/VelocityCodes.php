<?php
/**
 * Created by Sam.
 * At: 10/02/15 15:31
 */
namespace CybersourcePHP\Lookups;

class VelocityCodes
{
  private static $_codes = array(
    "VEL-ADDR" => "Different billing and/or shipping states (U.S. and Canada only) have been used several times with the credit card number and/or email address.",
    "VEL-CC" => "Different account numbers have been used several times with the same name or email address.",
    "VEL-NAME" => "Different names have been used several times with the credit card number and/or email address.",
    "VELS-CC" => "The account number has been used several times during the short tracking interval.",
    "VELI-CC The account number has been used several times during the medium tracking interval.",
    "VELL-CC" => "The account number has been used several times during the long tracking interval.",
    "VELV-CC" => "The account number has been used several times during the very long tracking interval.",
    "VELS-EM" => "The customer’s email address has been used several times during the short tracking interval.",
    "VELI-EM" => "The customer’s email address has been used several times during the medium tracking interval.",
    "VELL-EM" => "The customer’s email address has been used several times during the long tracking interval.",
    "VELV-EM" => "The customer’s email address has been used several times during the very long tracking interval.",
    "VELS-IP" => "The IP address has been used several times during the short tracking interval.",
    "VELI-IP" => "The IP address has been used several times during the medium tracking interval.",
    "VELL-IP" => "The IP address has been used several times during the long tracking interval.",
    "VELV-IP" => "The IP address has been used several times during the very long tracking interval.",
    "VELS-SA" => "The shipping address has been used several times during the short tracking interval.",
    "VELI-SA" => "The shipping address has been used several times during the medium tracking interval.",
    "VELL-SA" => "The shipping address has been used several times during the long tracking interval.",
    "VELV-SA" => "The shipping address has been used several times during the very long tracking interval.",
    "VELS-TIP" => "The true IP address has been used several times during the short interval.",
    "VELI-TIP" => "The true IP address has been used several times during the medium interval.",
    "VELL-TIP" => "The true IP address has been used several times during the long interval.",
    //Custom ones
    "MVEL-R5002" => "[JDI] 200 AUD x 1 day",
    "MVEL-R5003" => "[JDI] 200 CAD x 1 day",
    "MVEL-R5004" => "[JDI] 200 EUR x 1 day",
    "MVEL-R5005" => "[JDI] 200 GBP x 1 day",
    "MVEL-R5006" => "[JDI] 200 USD x 1 day",
    "MVEL-R5007" => "[JDI] 400 AUD x 1 week",
    "MVEL-R5008" => "[JDI] 400 CAD x 1 week",
    "MVEL-R5009" => "[JDI] 400 EUR x 1 week",
    "MVEL-R5010" => "[JDI] 400 GBP x 1 week",
    "MVEL-R5011" => "[JDI] 400 USD x 1 week",
    "MVEL-R5012" => "[JDI] Business/Reseller 1250 x 1 week",
    "MVEL-R5013" => "[JDI] Business/Reseller 750 x 1 day",
    "MVEL-R5014" => "[JDI] Card 2 x 1 week",
    "MVEL-R5015" => "[JDI] Device Fingerprint 2 x 1 day",
    "MVEL-R5016" => "[JDI] Device Fingerprint 3 x 1 week",
    "MVEL-R5017" => "[JDI] Email 2 x 1 week",
    "MVEL-R5018" => "[JDI] IP 3 x 1 week"
  );

  public static function lookup($code)
  {
    return isset(self::$_codes[$code]) ? self::$_codes[$code] : false;
  }
}
