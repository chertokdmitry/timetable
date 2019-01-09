<?php

use Rakit\Validation\Validator;
use Jenssegers\Blade\Blade;
        
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
            if ($this->checkForm($_POST, [
            'date1' => 'required',
            'date2' => 'required'
        ])) {
                $this->html = $this->model->showSchedule($_POST);
            }    
        } else {
            $this->html = $this->model->showIndexForm();
        }

        $this->render('index', $this->html);
    }

    public function render($template, $data)
    {
        $blade = new Blade( APP.'views',  APP.'cache');
        echo $blade->make($template, ['html' => $data]);
    }
    
    public function view()
    {
        $this->render('index', $this->model->view());
    }
    
    public function add()
    {

        if (!empty($_POST)) {
            if ($this->checkForm($_POST,  [
                'date' => 'required',
                'time' => 'required'
            ])) {
                $this->html = $this->model->add($_POST);
            }

        } else {
            $this->html = $this->model->makeForm('add', ' ');
        }
        $this->render('index', $this->html);
    }
    
    private function checkForm($data, $fieldsToCheck)
    {
        $validator = new Validator;
        $validation = $validator->validate($data, $fieldsToCheck);

        if ($validation->fails()) {
            $errors = $validation->errors();
             $errs = $errors->firstOfAll();
                          $this->html = '<div class="alert alert-danger" role="alert">'
                                  . 'Заполните все поля!<br><br>';
             foreach($errs as $key=>$err) {
                $this->html .= $err;
                $this->html .= '<br>';
             }
             $this->html .= '</div>';
            return false;
        } else {
            return true;
        }
    }
}
