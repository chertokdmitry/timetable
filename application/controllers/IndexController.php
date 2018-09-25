<?php

class IndexController extends Controller
{
    public $html;
   
    public function __construct()
    {
        $this->model = new Index();
    }
    
    public function index()
    {
        if (!empty($_POST)) {
            $this->html .= $this->model->showSchedule($_POST);
        } else {
             $this->html = $this->model->showIndexForm();
        }
        return $this->html;
    }
    
    public function view()
    {
        $this->html = $this->model->view();
        return $this->html;
    }
    
    public function add()
    {
        if (!empty($_POST)) {
            $this->html = $this->model->add($_POST);
        } else {
            $this->html = $this->model->makeForm('add', ' ');
        }
        return $this->html;
    }
}
