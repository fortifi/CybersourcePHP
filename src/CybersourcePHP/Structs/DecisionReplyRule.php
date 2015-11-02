<?php
/**
 * Created by Sam.
 * At: 28/10/2015 21:27
 */
namespace CybersourcePHP\Structs;

class DecisionReplyRule
{
  private $_name;
  private $_decision;
  private $_evaluation;

  public function __construct($name, $decision, $evaluation)
  {
    $this->_name = $name;
    $this->_decision = $decision;
    $this->_evaluation = $evaluation;
  }

  public function getName()
  {
    return $this->_name;
  }

  public function getDecision()
  {
    return $this->_decision;
  }

  public function getEvaluation()
  {
    return $this->_evaluation;
  }
}
