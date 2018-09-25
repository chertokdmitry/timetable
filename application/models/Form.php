<?php

class Form 
{
    public $html;
    
    public function __construct($header, $action, $fields = [], $id = 0, $time = true)
    {
        $this->html = '<form action="' . $action . '" method="post">'
                . '<h3>' . $header . '</h3>';
        if($fields[0] == 'id') unset($fields[0]);
        foreach ($fields as $field) {
        
            $input = $field[1] == 'linked' ? $this->getLinked($field[2], $field[0]) 
                    : $this->getInput($field, $time); 
            $this->html .= $input;
        }
        
        $this->html .= '<input type="hidden" name="hidden_id" value="' . $id . '">'
                . '<button type="submit" class="btn btn-primary">Submit</button></form>';
    }
    
    private function getLinked($data, $header)
    {
        
        $html = '<div class="form-group">
                <label for="' . $data[0] . '">' . $header . '</label>
                <select class="form-control" name="' . $data[0] . '" id="' . $data[0] . '">';
        
        $options = \R::findAll($data[0]);
        
        foreach ($options as $option) {
            
            $optionName = '';
            
            foreach ($data[1] as $name) {
                $optionName .= $option[$name];
                $optionName .= ' ';
            }
            
            $html .= '<option value="' . $option['id'] . '">' . $optionName . '</option>';
        }
        
        $html .= '</select>
                </div>';
        return $html;
    }
    
    private function getInput($data, $time = true)
    {
        $html = '<div class="form-group">
                        <label for="' . $data[2] . '">' .  $data[0] . '</label>
                        <input type="' . $data[1] . '" class="form-control" id="' 
                    . $data[2] . '" ' . ' name="' 
                    . $data[2] . '" placeholder=" ' 
                    . $data[2] . '">
                      </div>';
        if($time) {
                      $html .= '<div class="form-group">
                      <label for="time">Время: </label>
                       <input id="time" type="time" name="time">
                       </div>';
        }
        return $html;
    }
}
