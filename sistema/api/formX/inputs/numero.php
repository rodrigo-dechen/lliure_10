<?php
/**
 * Description of numero
 *
 * @author Rodrigo
 */

class numero extends formX_implement{

    private static
        $index = 0;

    private
        $id,
        $min,
        $max,
        $step;

    public function __construct($name, $label = null, $min = NULL, $max = NULL, $step = NULL){
        parent::__construct($name, $label);
        $this->id = self::$index++;
        $this->min = $min;
        $this->max = $max;
        $this->step = $step;
        lliure::addDocHead('api/formX/includes/numero/jquery.numero.js');
        lliure::addDocHead('api/formX/includes/numero/numero.css');
    }

    public function form($dados){
        return
            '<input class="fp_input inputNumeru_' . $this->id . '" type="hidden" name="' . $this->name . '"'.$this->getValueStandard($this->name, $dados).'>
            <div class="inputNumeru">
                <span class="fp_input inputNumeru_' . $this->id . '"></span>
                <span class="inputNumeruUp fp_botao inputNumeruUp_' . $this->id . '"><button><span class="seta cima"></span></button></span>
                <span class="inputNumeruDown fp_botao inputNumeruDown_' . $this->id . '"><button><span class="seta baixo"></span></button></span>
            </div>    
            <script type="text/javascript">
                $("input.inputNumeru_' . $this->id . '").numero({
                    '.(isset($dados[$this->name])? 'defaut: '.$dados[$this->name].',':'').'
                    '.(is_numeric($this->step)? 'step: '.$this->step.',':'').'
                    '.(is_numeric($this->min)? 'min: '.$this->min.',':'').'
                    '.(is_numeric($this->max)? 'max: '.$this->max.',':'').'
                    span: "span.inputNumeru_' . $this->id . '",
                    up: ".inputNumeruUp_' . $this->id . '",
                    down: ".inputNumeruDown_'.$this->id.'"
                });
            </script>'
        ;
    }

}