<?php
/**
 * Created by sam
 * At: 19/05/2014 15:16
 */
namespace CybersourcePHP;

use CybersourcePHP\Exceptions\ConfigException;
use CybersourcePHP\Requests\AfsRequest;
use CybersourcePHP\Structs\Configuration;

class CybersourceClient
{
  /** @var \SoapClient $soapClient */
  private $_soapClient;
  private $_config;

  public function __construct(Configuration $configuration)
  {
    if($configuration == null || !isset($configuration->merchantID) || !isset($configuration->apiKey) || !isset($configuration->orgID))
    {
      throw new ConfigException("Config is not set correctly");
    }
    $this->_config = $configuration;
    $this->_soapClient = new \SoapClient($configuration->wsdl, array(
      "cache_wsdl" => WSDL_CACHE_BOTH,
      "compression" => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,
      "encoding" => "utf-8",
      "exceptions" => true,
      "connection_timeout" => 30,
      "trace" => 1
    ));
    $this->_setWSSEHeaders();
  }

  private function _setWSSEHeaders()
  {
    $user = new \SoapVar($this->_config->merchantID, XSD_STRING, null, $this->_config->wsseNS, null, $this->_config->wsseNS);
    $pass = new \SoapVar($this->_config->apiKey, XSD_STRING, null, $this->_config->typeNS, null, $this->_config->typeNS);
    $username_token = new \stdClass();
    $username_token->Username = $user;
    $username_token->Password = $pass;
    $username_token = new \SoapVar($username_token, SOAP_ENC_OBJECT, null, $this->_config->wsseNS, 'UsernameToken', $this->_config->wsseNS);
    $security = new \stdClass();
    $security->UsernameToken = $username_token;
    $security = new \SoapVar($security, SOAP_ENC_OBJECT, null, $this->_config->wsseNS, 'Security', $this->_config->wsseNS);
    $header = new \SoapHeader($this->_config->wsseNS, 'Security', $security, true);
    $this->_soapClient->__setSoapHeaders($header);
  }

  public function afsRequest()
  {
    $request = new AfsRequest($this->_config->merchantID, "CybersourcePHP_" . time());
    $request->setSoapClient($this->_soapClient);
    return $request;
  }
} 
