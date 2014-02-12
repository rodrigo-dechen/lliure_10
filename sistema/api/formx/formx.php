<?php


if(!function_exists('new_user_class_array')){

    /**
     * Cria uma class com o nome e os parametros passado.
     * devolve a class crida ou NULL caso nao consiga criala.
     * @param String $class nome da class a ser criada
     * @param array $params parametro passados para class
     * @return Object||NULL retorna o obj criado ou NULL caso nao conseiga ter criado
     */
    function new_user_class_array ($class, array $params){

        $esecut = array();

        foreach($params as $chave => $valor)
            if (is_string($valor))
                $esecut[] = '\'' . $valor . '\'';
            elseif (is_numeric($valor))
                $esecut[] = $valor;
            else
                $esecut[] = '$params[' . $chave . ']';

        $retorno = null;

        if(class_exists($class))
            eval('$retorno = new ' . $class . '(' . implode(', ', $esecut) . ');');

        return $retorno;

    }

    /**
     * Cria uma class com o nome e os parametros passado.
     * devolve a class crida ou NULL caso nao consiga criala.
     * @param String $class nome da class a ser criada
     * @param mixer $params [opcional]<br/> parametro passados para class
     * @return Object||NULL retorna o obj criado ou NULL caso nao conseiga ter criado
     */
    function new_user_class(){

        $params = func_get_args();
        $class = array_shift($params);

        return new_user_class_array($class, $params);

    }

}

class formX_element{

    protected

    /**
     * variavel para que aemasena o tamanho em porcentagem d input
     */
    $width = NULL,

    /**
     * Variavel padrao que contem a label (nome visivel) do input.<br/>
     * Se setada como <b>NULL</b> a label nao aparece
     */
    $label = NULL,

    /**
     * Variavel padrao que contem a label (nome visivel) do input.<br/>
     * Se setada como <b>NULL</b> a label nao aparece
     */
    $name = NULL,

    /**
     * variavel padra, garda um comentario sobre o input.<br/>
     * geralmente fica a baixo do input.<br/>
     * sua implementação é opicional para o desenvovedor.
     */
    $observation = NULL;
    
    public function __construct($name = NULL, $label = NULL) {
        $this->name = $name;
        $this->label = $label;
    }


    final function setWidth($width){
        $this->width = $width;
    }
    
    final function getWidth(){
        if ($this->width !== NULL && $this->width != 100)
            return ' style="width: ' . $this->width . '%"';
        else
            return '';
    }
    
    final function getLabel(){
        if ($this->label !== NULL)
            return '<label class="fp_label">' . $this->label . '</label>';
        else
            return '';
    }
    
    final function getObservation(){
        if ($this->observation !== NULL)
            return '<span class="fp_observation">' . $this->label . '</span>';
        else
            return '';
    }
    
    final function getValueStandard($name, $dados){
        return ( isset($dados[$name]) && $dados[$name] != ''? ' value="' . $dados[$name] . '"': '');
    }
    
}

/**
 * extend obrigatorio para a cria??o de um input personalisado.
 *
 * @author Rodrigo
 */

abstract class formX_implement extends formX_element{

    /**
     * <p>Metodo nessesario para inpelmenta?oes ao form padrao</p>
     * <p>Este metodo ? responsavel por retornar o layout de seu elemento no form</p>
     * <p>recebe tambem os dados (variavel $dados) que o foi passado ao formulario.
     * podendo assim ferificar valor pre existente para seu input caso o forulario sirva para edi??o.</p>
     */
    abstract function form($dados);

}

/**
 * Description of formx
 *
 * @author Rodrigo
 */

class formx{
    
    private 
        $dados = array(),
        $action,
        $inputHidden = array(),
        $form = array(),
        $correnteFieldset = NULL,
        $id = null,
        $class = null;

    public function __construct($id = NULL, $class = null) {
        lliure::addDocHead('api/formX/includes/formx/formx.css');
        //lliure::addDocHead('api/formX/includes/formx/formx.js');
        autoLoad::setPath('api/formx/inputs');
        autoLoad::setFunction(function ($name){
            return 'api/formx/inputs/'.$name.'.php';
        });
        $this->id = $id;
        $this->class = $class;
    }

    public function dados(array $dados){
        $this->dados = $dados;
        return $this;
    }

    public function action($action){
        $this->action = $action;
        return $this;
    }

    public function fieldset($legend = NULL){
        $fieldset = new fieldset($legend);
        $this->correnteFieldset = $fieldset;
        $this->form[] = $fieldset;
        return $this;
    }
    
    private function getCorrenteFieldset(){
        if ($this->correnteFieldset === NULL)
            $this->fieldset();
        
        return $this->correnteFieldset;
    }

    /**
     * Lista de tamanhos (width) dos elementos da linha que esta sendo criada. 
     * @param int $por1 primeiro elemeto da lista.
     * @param int $por2 segundo elemeto da lista.
     * @param int $por3 terceiro elemeto da lista.
     * @param int $porN enesimo elemeto da lista.
     */
    public function linha(){
        $this->getCorrenteFieldset()->setElement(new linha(func_get_args()));
        return $this;
    }
    
    public function inputHidden($name){
        $element = new inputHidden($name);
        $this->inputHidden[] = $element;
        return $this;
    }

    /**
     * Recebe um objeto de um elemento e e o coloca no formulario somente se <pre>$mostar</pre> for igual a <b>TRUE</b>.
     * @param formX_implement $element
     * @param boolean $mostra;
     */
    function addElement($pergunta, $true = NULL, $false = NULL){
        
        if(is_object($pergunta) && is_a($pergunta, 'formX_implement'))
            $this->getCorrenteFieldset()->setElement($element);
        elseif(is_bool($pergunta)){
            if($pergunta){
                if(is_object($true) && is_a($true, 'formX_implement'))
                    $this->getCorrenteFieldset()->setElement($true);
            }else{
                if(is_object($false) && is_a($false, 'formX_implement'))
                    $this->getCorrenteFieldset()->setElement($false);
            }
        }

        return $this;
    }

    function __call($name, $arguments){
        
        $element = new_user_class_array('formX_'.$name, $arguments);
        
        if(is_null($element))
            $element = new_user_class_array($name, $arguments);
        
        if ($element !== NULL && is_a($element, 'formX_implement'))
            $this->getCorrenteFieldset()->setElement($element);

        return $this;
    }
    
    public function form(){
        return $this->__toString();
    }
    
    public function __toString(){
        
        $inputHidden = '';
        foreach ($this->inputHidden as $valor)
            $inputHidden .= $valor->form($this->dados);
        
        $retorno = '';
        foreach ($this->form as $valor)
            $retorno .= $valor->form($this->dados);

        $retorno = 
            '<form'.($this->id!==NULL? ' id="'.$this->id.'"' : '').' class="formX'.($this->class!==NULL? ' ' . $this->class : '').'" action="'.$this->action.'" method="post">'.
                $inputHidden.
                $retorno.
                '<div style="clear: both"></div>'.
            '</form>';

        return $retorno;
    }

}

class fieldset{
    
    static private 
        $p = 0;

    private 
        $i,
        $legend,
        $correntLine = NULL,
        $elements = array();
    
    public function __construct($legend = NULL){
        $this->i = ++self::$p;
        $this->legend = $legend;
    }

    public function setElement($element){
        if (is_a($element, 'linha')){
            $this->correntLine = $element;
            $this->elements[] = $element;
        }else{
            if ($this->correntLine !== NULL && $this->correntLine->aVaga()){
                $this->correntLine->setElement($element);
            }else{
                $this->correntLine = new linha();
                $this->elements[] = $this->correntLine;
                $this->correntLine->setElement($element);
            }
        }
    }
    
    public function form($dados){
        $retorno = '';

        if (count($this->elements) > 0 || $this->legend !== null){

            foreach ($this->elements as $valor)
                $retorno .= $valor->form($dados);

            $retorno = 
                '<fieldset'.($this->i == self::$p? ' class="fx_fieldset_lest"': '').' style="z-index: '.(self::$p - $this->i + 1).';">'.
                    ($this->legend !== null? '<legend class="fx_legend">' . $this->legend . '</legend>': '').
                    $retorno.
                '</fieldset>';
        }

        return $retorno;

    }

}

class linha{
    
    const 
        float_left = 'left',
        float_right = 'right';
    
    private static 
        $p = 0;

    private
        $i,
        $arredondamento = 3,
        $widths = array(),
        $elements = array(),
        $autoResize = true,
        $float = linha::float_left;

    public function __construct(array $widths = array(1)){
        
        $this->i = ++self::$p;
        
        if (count($widths) == 0)
            $widths = array(1);
        
        if (count($widths) == 1 && isset($widths[0]) && $widths[0] > 1){

            $this->autoResize = FALSE;
            for($i = 0; $i < $widths[0]; $i++)
                $this->widths[] = NULL;

        }elseif (count($widths) == 2 && isset($widths[0]) && $widths[0] > 1 && isset($widths[1]) && is_string($widths[1])){

            $this->float = $widths[1];
            
            $this->autoResize = FALSE;
            for($i = 0; $i < $widths[0]; $i++)
                $this->widths[] = NULL;

        }else{

            $total = 0;
            
            //soma total
            foreach ($widths as $valor)
                $total += $valor;

            //calcula as porcentagens
            foreach ($widths as $valor)
                $this->widths[] = (float) number_format((($valor / $total) * 100), $this->arredondamento);
            
        }

    }
    
    private function interFor100($total){
        if ($total != 100)
            return $total - 100;
        else
            return NULL;
    }

    public function aVaga(){
        return !empty($this->widths);
    }

    public function setElement(formX_implement $element){
        $element->setWidth($this->getCorrentWidth());
        $this->elements[] = $element;
    }
    
    public function getCorrentWidth(){
        return array_shift($this->widths);
    }
    
    public function form($dados){
        $retorno = '';
        
        $i = 0;
        
        if (count($this->elements) > 0)
            foreach ($this->elements as $valor)
                $retorno .= 
                    '<div class="fx_unidade'.(++$i == 1? ' fx_unidade_first':'').($i == count($this->elements)? ' fx_unidade_last':'').'"' . ($this->autoResize? $valor->getWidth(): 'style="width: auto;"') . '>'.
                        $valor->getLabel().
                        $valor->form($dados).
                    '</div>';

        $retorno =
            '<div class="fx_linha'.( $this->i == self::$p? ' fx_linha_lest': '').'" style="z-index: '.(self::$p - $this->i + 1).';">'.
                ($this->float != linha::float_left? '<div class="fx_linha_'.$this->float.'">': '').
                    $retorno.
                ($this->float != linha::float_left? '</div>': '').
            '</div>';

        return $retorno;
    }
    
}

?>