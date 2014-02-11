<?php 

switch (!empty($_GET[1])? $_GET[1]: NULL){

    case 'etapa-1': 
        lliure::addDocHead('suplimentos/js/jquery.validate.js');
        lliure::addDocFooter(lliure::getPathApp(). WS. 'js'. WS. 'etapa1.js');
    break; 

    default:

    break;
    
}