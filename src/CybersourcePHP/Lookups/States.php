<?php
/**
 * Created by sam
 * At: 06/06/2014 13:52
 */
namespace CybersourcePHP\Lookups;

use CybersourcePHP\Structs\StateInfo;

class States
{
  private static $_stateMap = array(
    "AB"=>"ALBERTA", //CA
    "AL"=>"ALABAMA",
    "AK"=>"ALASKA",
    "AZ"=>"ARIZONA",
    "AR"=>"ARKANSAS",
    "BC"=>"BRITISH COLUMBIA", //CA
    "CA"=>"CALIFORNIA",
    "CO"=>"COLORADO",
    "CT"=>"CONNECTICUT",
    "DE"=>"DELAWARE",
    "DC"=>"DISTRICT OF COLUMBIA",
    "FL"=>"FLORIDA",
    "GA"=>"GEORGIA",
    "HI"=>"HAWAII",
    "ID"=>"IDAHO",
    "IL"=>"ILLINOIS",
    "IN"=>"INDIANA",
    "IA"=>"IOWA",
    "KS"=>"KANSAS",
    "KY"=>"KENTUCKY",
    "LA"=>"LOUISIANA",
    "ME"=>"MAINE",
    "MD"=>"MARYLAND",
    "MA"=>"MASSACHUSETTS",
    "MB"=>"MANITOBA", //CA
    "MI"=>"MICHIGAN",
    "MN"=>"MINNESOTA",
    "MS"=>"MISSISSIPPI",
    "MO"=>"MISSOURI",
    "MT"=>"MONTANA",
    "NE"=>"NEBRASKA",
    "NV"=>"NEVADA",
    "NB"=>"NEW BRUNSWICK", //CA
    "NH"=>"NEW HAMPSHIRE",
    "NJ"=>"NEW JERSEY",
    "NL"=>"NEWFOUNDLAND AND LABRADOR", //CA
    "NM"=>"NEW MEXICO",
    "NY"=>"NEW YORK",
    "NC"=>"NORTH CAROLINA",
    "ND"=>"NORTH DAKOTA",
    "NS"=>"NOVA SCOTIA", //CA
    "OH"=>"OHIO",
    "OK"=>"OKLAHOMA",
    "ON"=>"ONTARIO", //CA
    "OR"=>"OREGON",
    "PA"=>"PENNSYLVANIA",
    "PE"=>"PRINCE EDWARD ISLAND", //CA
    "QC"=>"QUEBEC", //CA
    "RI"=>"RHODE ISLAND",
    "SC"=>"SOUTH CAROLINA",
    "SD"=>"SOUTH DAKOTA",
    "SK"=>"SASKATCHEWAN", //CA
    "TN"=>"TENNESSEE",
    "TX"=>"TEXAS",
    "UT"=>"UTAH",
    "VT"=>"VERMONT",
    "VA"=>"VIRGINIA",
    "WA"=>"WASHINGTON",
    "WV"=>"WEST VIRGINIA",
    "WI"=>"WISCONSIN",
    "WY"=>"WYOMING"
  );

  public static function getState($state)
  {
    $state = trim($state);
    $state = preg_replace("/[^A-z\s]/", "", $state); //Remove punctuation
    $state = preg_replace("/\s{2,}/", " ", $state);
    $state = str_replace("é", "e", $state);
    $state = str_replace("É", "E", $state);
    $state = strtoupper($state);
    if(isset(self::$_stateMap[$state])) //Code => Name
    {
      return new StateInfo($state, self::$_stateMap[$state]);
    }
    else
    {
      $reverseMap = array_flip(self::$_stateMap); //Name => Code
      if(isset($reverseMap[$state]))
      {
        return new StateInfo($reverseMap[$state], $state);
      }
      else
      {
        return null;
      }
    }
  }
} 
