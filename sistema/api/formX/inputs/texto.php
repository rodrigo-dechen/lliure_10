<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of texto
 *
 * @author Rodrigo
 */
class texto extends formX_implement{
    
    private 
    $texto;


    public function __construct($label = NULL, $texto) {
        parent::__construct('', $label);
        $this->texto = $texto;
        lliure::addDocHead('api'.DS.'formX'.DS.'includes'.DS.'texto'.DS.'css.css');
    }

    public function form($dados) {
        return '<div class="texto">' . $this->texto . '</div>';
    } 
    
}

?>
