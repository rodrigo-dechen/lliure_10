<?php
/**
 * Description of input
 *
 * @author Rodrigo
 */

class input extends formX_implement{

    public 
        $type;

    public function __construct($name, $label = null, $type = 'text', $observation = null){
        parent::__construct($name, $label);
        $this->type = $type;
        $this->observation = $observation;
    }

    public function form($dados){
        return '
            <input class="fx_input" name="' . $this->name . '" type="' . $this->type . '" '.$this->getValueStandard($this->name, $dados).' />';
    }

}

?>
