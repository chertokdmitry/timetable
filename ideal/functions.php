<?php

function debug($arr) 
{
    echo '<pre>' . print_r($arr, true) . '</pre>';
}

function getHours($dateTime)
{
    $date = new DateTime($dateTime);
    return $date->format('H');
}