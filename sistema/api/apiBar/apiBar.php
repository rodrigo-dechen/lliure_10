<?php

/**
 * Description of apiBar
 *
 * @author Rodrigo
 */

class apiBar{
    
    private 
    $bottoes = array(),
    $nome = '';


    public function __construct() {
        lliure::addDocHead('api/apiBar/estilo.css');
    }
    
    public function addBottom(){
        $botao =  new apiBarButtom();
        $this->bottoes[] = $botao;
        return $botao;
    }
    public function nome($nome) {
        $this->nome = $nome;
        return $this;
    }

    public function show(){
        return $this->__toString();
    }
    
    public function __toString(){
        
        $return = '<div id="appBar"><div class="appBar_inter"><h1>'.  $this->nome.'</h1> <div class="botoes">';
	
        if(!empty($this->bottoes))
            foreach($this->bottoes as $chave => $valor)
                $return .= '<a href="'.$valor->getHref().'" title="'.$valor->getTitulo().'" '.$valor->getAttrs().'><img src="'.$valor->getImg().'" alt=""/>'.$valor->getTitulo().'</a>';

        $return .= '</div><div class="both"></div></div></div>';
        
        return $return;
        
    }
    
}

class apiBarButtom{
    
    private
    $img = '',
    $titulo = '',
    $href = '',
    $attrs = '';
    
    public function setImg($img) {
        $this->img = $img;
        return $this;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
        return $this;
    }

    public function setHref($href) {
        $this->href = $href;
        return $this;
    }

    public function setAttrs($attrs) {
        $retorno = '';
        if (is_array($attrs))
            foreach ($attrs as $key => $value)
                $retorno = ($retorno==''? '': ' ').$key.'="'.$value.'"';
        else
            $retorno = $attrs;
        $this->attrs = $retorno;
        return $this;
    }
    
    public function getImg() {
        return $this->img;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getHref() {
        return $this->href;
    }

    public function getAttrs() {
        return $this->attrs;
    }

}

?>
