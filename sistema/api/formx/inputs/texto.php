<?php

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
        lliure::addDocHead('api'.WS.'formx'.WS.'includes'.WS.'texto'.WS.'texto.css');
    }

    public function form($dados) {
        return '<div class="texto">' . $this->texto . '</div>';
    } 
    
}

