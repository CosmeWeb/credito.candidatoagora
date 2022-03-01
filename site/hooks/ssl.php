<?php
#######################################################################################################
function redirect_ssl()
{
    $CI =& get_instance();
    $class = $CI->router->class;
    $exclude =  array();  // add more controller name to exclude ssl.
   // P( in_array($class,$exclude), $class, $exclude);
   // exit();
    if(IsLocal())
      return;
    SemWWW();
    if(in_array($class,$exclude))
    {
      // redirecting to ssl.
      $CI->config->config['base_url'] = str_replace('https://', 'http://', $CI->config->config['base_url']);
      if ($_SERVER['SERVER_PORT'] == 443) 
        redirect($CI->uri->uri_string());
    } 
    else
    {
      // redirecting with no ssl.
      $CI->config->config['base_url'] = str_replace('http://', 'https://', $CI->config->config['base_url']);
      if ($_SERVER['SERVER_PORT'] != 443) 
        redirect($CI->uri->uri_string());
    }
}
#######################################################################################################
function SemWWW()
{
    $dominio = GetNomeServidor();
    $pos = strpos($dominio, "www.");
    if($pos === false)
      return;
    if($pos == 0)
    {
        $CI =& get_instance();
        redirect($CI->uri->uri_string());
        exit;
    }
}
#######################################################################################################
function IsLocal()
{
    if (GetIPServidor() == GetIP())
    {
        return true;
    }
    return false;
}
?>