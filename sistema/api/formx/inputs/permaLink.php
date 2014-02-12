<?php
/**
 * Description of permaLink
 *
 * @author Rodrigo
 */

class permaLink extends formX_implement{
    
    static $id = 0;
    public
        $meuInd,
        $referencia;

    public function __construct($name, $label, $referencia) {
        parent::__construct($name, $label);
        $this->meuId = self::$id++;
        $this->name = $name;
        $this->label = $label;
        $this->referencia = $referencia;
    }

    public function form($dados) {
        return '';
    }
    
}

?>
