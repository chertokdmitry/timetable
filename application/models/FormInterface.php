<?php

interface FormInterface
{
    public function makeFooter($id);
    public function makeHeader($header, $action);
    public function makeFields($fields, $time);
    public function makeLinked($data, $header);
    public function makeOptions($data);
    public function makeInput($data, $time);
}
