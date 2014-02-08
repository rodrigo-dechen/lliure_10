<?php

$file = lliure::getPathApp().DS.'headers'.DS.(isset($_GET[1])? $_GET[1]: 'index').'.php';

if(is_file($file))
    require_once $file;

?>