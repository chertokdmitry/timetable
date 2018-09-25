<?php

class Controller extends Controller
{
    public $html;
    
    public function index()
    {
        $this->model = new Admin();
        
        if (!empty($_POST)) {
            $this->html .= $this->model->add(App::gi()->uri->table, $_POST);
        } else {
            $this->html .= $this->model->makeForm('add', App::gi()->uri->table, ' ');
        }
        return $this->html;
    }
}
