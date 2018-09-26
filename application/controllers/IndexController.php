<?php

use Rakit\Validation\Validator;
        
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
            if ($this->checkForm($_POST,  [
            'date' => 'required',
            'time' => 'required'
        ])) {
                $this->html = $this->model->add($_POST);
            } 

        } else {
            $this->html = $this->model->makeForm('add', ' ');
        }
        return $this->html;
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
