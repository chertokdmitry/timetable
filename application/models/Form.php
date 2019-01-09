<?php

class Form implements FormInterface

{
    public $html;
    
    public function __construct($header, $action, $fields = [], $id = 0, $time = true)
    {
        $this->html = $this->makeHeader($header, $action);
        $this->html .= $this->makeFields($fields, $time);
        $this->html .= $this->makeFooter($id);
    }

    public function makeHeader($header, $action)
    {
        return '<form action="' . $action . '" method="post">'
            . '<h3>' . $header . '</h3>';
    }

    public function makeFooter($id)
    {
        return '<input type="hidden" name="hidden_id" value="' . $id . '">'
            . '<button type="submit" class="btn btn-primary">Submit</button></form>';
    }

    public function makeFields($fields, $time)
    {
        $html = '';
        if($fields[0] == 'id') unset($fields[0]);
        foreach ($fields as $field) {

            $input = $field[1] == 'linked' ? $this->makeLinked($field[2], $field[0])
                : $this->makeInput($field, $time);
            $html .= $input;
        }

        return $html;
    }
    
    public function makeLinked($data, $header)
    {
        
        $html = '<div class="form-group"><label 
                for="' . $data[0] . '">' . $header . '</label><select 
                class="form-control" 
                name="' . $data[0] . '" 
                id="' . $data[0] . '">';

        $html .= $this->makeOptions($data);

        
        $html .= '</select></div>';
        return $html;
    }

    public function makeOptions($data)
    {
        $html = '';
        $options = \R::findAll($data[0]);

        foreach ($options as $option) {

            $optionName = '';

            foreach ($data[1] as $name) {
                $optionName .= $option[$name];
                $optionName .= ' ';
            }

            $html .= '<option 
                       value="' . $option['id'] . '">' . $optionName . '</option>';
        }

        return $html;
    }
    
    public function makeInput($data, $time = true)
    {
        $html = '<div class="form-group"><label 
                        for="' . $data[2] . '">' .  $data[0] . '</label><input 
                        type="' . $data[1] . '" class="form-control" id="'
                    . $data[2] . '" ' . ' name="' 
                    . $data[2] . '" 
                    placeholder=" '
                    . $data[2] . '"></div>';
        if($time) {
                      $html .= '<div class="form-group"><label 
                      for="time">Время: </label><input 
                      id="time" 
                      type="time" 
                      name="time"></div>';
        }
        return $html;
    }
}
