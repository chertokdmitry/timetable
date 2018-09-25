<?php
class App extends Singleton{
    
    public function __construct()
    {
        $config = include APP.'config.php';
        $this->config = new Registry($config);
        include  IDEAL . 'classes/db/Db.php';
        $this->db = Db::gi();
    }

    function start()
    {
        $this->uri = new Registry(Router::gi()->parse($_SERVER['REQUEST_URI'])); 
        $controllerName = ucfirst($this->uri->controller) . 'Controller';
 
        $controller = $controllerName::gi();
        
//        ob_start();
        $content = $controller->__call($this->uri->action, array($this->uri->id));
//        $content = ob_get_clean();
    
        $controller->renderPage($content);
    }
}
