<?php
/**
 * Description of password
 *
 * @author Rodrigo
 */
class password extends formX_implement{
    
    public function __construct($name, $label = NULL) {
        parent::__construct($name, $label);
    }

    public function form($dados) {
        return '<input class="fp_input" type="password" name="' . $this->name . '" />';
    }
    
}

?>

