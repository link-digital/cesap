<?php

define('ZEUS_ENDPOINT', variable_get('zeus_api_url'));

class ZeusServices
{
  private static $ENDPOINT = ZEUS_ENDPOINT;
  private $soapClient;

  public function __construct()
  {
    $this->soapClient = new SoapClient(self::$ENDPOINT);
  }

  public function accountStatus($dni)
  {
    $params = $this->params();
    $params['Body'] = "<Interfaz_ZeusClubes><EstadoSocio><vchidentificacion>{$dni}</vchidentificacion></EstadoSocio></Interfaz_ZeusClubes>";
    return $this->executeAction($params);
  }

  private function __executeAction($params)
  {
    $info = $this->_executeAction($params);

    if($info->ExecuteActionSOAPResult->Status == 'SUCCESS')
    {
      return simplexml_load_string($info->ExecuteActionSOAPResult->Body);
    }  
    else if($info->ExecuteActionSOAPResult->Status == 'FAILD')
    {
      // $output = 'FAILD';
      throw new Exception($info->ExecuteActionSOAPResult->Message);
    }  
  }

  private function executeAction($params)
  {
    try
    {
      $info = $this->soapClient->ExecuteActionSOAP((object) array('Request' => $params));
      // return $info;
    }
    catch(Exception $e)
    {
      drupal_set_message('Error haciendo la consulta, por favor intente más tarde.', 'error');
      watchdog('zeus_service', 'Imposible conectar a Zeus: ' . $e->getMessage(), array(), WATCHDOG_ALERT);
    }

    if(!$info)
    {
      return false;
    }
    else if($info->ExecuteActionSOAPResult->Status == 'SUCCESS')
    {
      return simplexml_load_string($info->ExecuteActionSOAPResult->Body);
    }  
    else if($info->ExecuteActionSOAPResult->Status == 'FAILD')
    {
      // $output = 'FAILD';
      throw new Exception($info->ExecuteActionSOAPResult->Message);
    }  


    // if($output == 'FAILD')
    // {
    //   throw new Exception($info->ExecuteActionSOAPResult->Message);
    // }
  }

  private function params()
  {
    return array(
      'TypeSQL' => 'TRUE',
      'DynamicProperty' => '',
      'User' => 'wsprueba1',
      'Password' => 'wsprueba1',
      'Action' => 'ConsultarEstadoSocio',
    );
  }
}