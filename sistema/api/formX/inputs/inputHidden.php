<?php
/**
 * Description of inputHidden
 *
 * @author Rodrigo
 */
class inputHidden extends formX_implement {

    public function __construct($name) {
        parent::__construct($name);
    }

    public function form($dados) {
        return '
            <input type="hidden" name="' . $this->name . '" ' . $this->getValueStandard($this->name, $dados) . '>';
    }

}

?>
