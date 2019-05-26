<?php

define('EA_ENDPOINT', variable_get('ea_api_url'));

class EAServices
{
  private static $ENDPOINT = EA_ENDPOINT;

  public static function get($resource)
  {
    return self::request($resource);
  }

  public static function getAssoc($resource)
  {
    $res = self::request($resource);
    $output = array();
    if(is_array($res))
    {
      foreach($res as $row)
      {
        $output[$row->id] = $row;
      }
    }

    return $output;
  }

  public static function post($resource, $data)
  {
    $res = self::request($resource, $data, 'POST');
    return $res;
  }

  public static function DEPRECATED__categories()
  {
    return self::request('categories');
  }

  private function resourceUri($resource)
  {
    return $this->$ENDPOINT . $resource;
  }

  private static function request($resource, $data = NULL, $method = 'GET')
  {
    $uri = self::$ENDPOINT . $resource;
    // echo $uri; die;
    $options = array(
      'method' => $method,
    );

    if($data)
    {
      $options['data'] = json_encode($data);
    }

    $r = drupal_http_request($uri, $options);
    // file_put_contents('./easy.log', $uri);

    if($r->code >= 200 && $r->code < 300)
    {
      return json_decode($r->data);
    }
    else
    {
      // file_put_contents('./easy.log', $r->data);
      throw new Exception($r->error);
    }
  }

}