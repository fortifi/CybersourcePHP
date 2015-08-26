<?php
/**
 * Created by sam
 * At: 27/05/2014 14:19
 */
namespace CybersourcePHP\Structs;

class DecisionReply
{
  public $casePriority;
  public $activeProfileReply;
  public $velocityInfoCode;

  public function __construct($priority, $activeProfile, $velocity)
  {
    $this->casePriority = $priority;
    $this->activeProfileReply = $activeProfile;
    if(!is_array($velocity))
    {
      $velocity = array($velocity);
    }
    $this->velocityInfoCode = array();
    foreach($velocity as $code)
    {
      $this->velocityInfoCode[] = new VelocityCode($code);
    }
  }
} 
