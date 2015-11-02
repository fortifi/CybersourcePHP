<?php
/**
 * Created by Sam.
 * At: 28/10/2015 21:28
 */
namespace CybersourcePHP\Replies;

use CybersourcePHP\Structs\DecisionReplyRule;
use CybersourcePHP\Structs\VelocityCode;

class DecisionReply
{
  private $_casePriority;
  private $_selectedBy;
  private $_profileName;
  private $_rulesTriggered;
  private $_velocityInfoCodes;

  public function __construct($decisionReply, $delimiter)
  {
    $this->_casePriority = isset($decisionReply->casePriority) ? $decisionReply->casePriority : -1;
    if(isset($decisionReply->activeProfileReply))
    {
      $this->_selectedBy = isset($decisionReply->activeProfileReply->selectedBy) ? $decisionReply->activeProfileReply->selectedBy : "Unknown";
      $this->_profileName = isset($decisionReply->activeProfileReply->name) ? $decisionReply->activeProfileReply->name : "Unknown";
      $this->_rulesTriggered = array();
      if(isset($decisionReply->activeProfileReply->rulesTriggered) && isset($decisionReply->activeProfileReply->rulesTriggered->ruleResultItem))
      {
        //Why must you do this?
        if(!is_array($decisionReply->activeProfileReply->rulesTriggered->ruleResultItem))
        {
          $decisionReply->activeProfileReply->rulesTriggered->ruleREsultItem = array($decisionReply->activeProfileReply->rulesTriggered->ruleResultItem);
        }
        foreach($decisionReply->activeProfileReply->rulesTriggered->ruleResultItem as $rule)
        {
          $this->_rulesTriggered[] = new DecisionReplyRule($rule->name, $rule->decision, $rule->evaluation);
        }
      }
    }
    else
    {
      $this->_selectedBy = "Unknown";
      $this->_profileName = "Unknown";
      $this->_rulesTriggered = array();
    }
    $this->_velocityInfoCodes = array();
    if(isset($decisionReply->velocityInfoCode))
    {
      $codes = explode($delimiter, $decisionReply->velocityInfoCode);
      foreach($codes as $code)
      {
        if($code != "")
        {
          $this->_velocityInfoCodes[] = new VelocityCode($code);
        }
      }
    }
  }

  public function getCasePriority()
  {
    return $this->_casePriority;
  }

  public function getSelectedBy()
  {
    return $this->_selectedBy;
  }

  public function getProfileName()
  {
    return $this->_profileName;
  }

  public function getRulesTriggered()
  {
    return $this->_rulesTriggered;
  }

  public function getVelocityInfoCodes()
  {
    return $this->_velocityInfoCodes;
  }
}
