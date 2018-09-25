<?php

class Router extends Singleton
{
    function parse($url)
    {    
        $path = $_REQUEST['route'];
        $reg_paths = App::gi()->config->router; 
        $request = $_REQUEST;
        $request['controller'] = app::gi()->config->default_controller;
        $request['action'] = app::gi()->config->default_action;
        $request['table'] = '';
        $request['id'] = 0;
        $parts = parse_url($url);

        if (isset($parts['query']) and !empty($parts['query'])) {
            $path = str_replace('?'.$parts['query'], '', $path);
            parse_str($parts['query'], $req);
            $request = array_merge($request, $req);
        }
     
      $newPath = $_REQUEST['route'];
        foreach($reg_paths as $regxp=>$keys) { 
            
            if (preg_match('#'.$regxp.'#Uuis', $newPath)) {
                $keys = explode('/',$keys);
                $path2 = explode('/', $newPath);
                foreach ($keys as $key=>$value) {  
                    $this->$value = $path2[$key];
                    $request[$value] = $path2[$key];
                }
            }
        }
    
        return $request;
  }
}
