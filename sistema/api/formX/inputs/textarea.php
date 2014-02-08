<?php
/**
 * Description of textarea
 *
 * @author Rodrigo
 */

define('TEXTAREA-NO-RESIZE', 1);
define('TEXTAREA-RESIZE-X', 2);
define('TEXTAREA-RESIZE-Y', 3);

class textarea extends formX_implement{
    
    const 
    NO_RESIZE = 0,
    RESIZE_X = 1,
    RESIZE_Y = 2;

    private 
    $modo;

    public function __construct($name, $label = null, $modo = -1){
        parent::__construct($name, $label);
        $this->modo = $modo;
    }

    public function form($dados){
        $modos = array('none', 'vertical', 'horizontal');
        $modo = ($this->modo == -1? '' : ' style="resize:'.($modos[$this->modo]).';"');
        
        return'
            <textarea class="fp_textarea" name="' . $this->name . '"' . $modo . '>' . (isset($dados[$this->name])? $dados[$this->name]: '') . '</textarea>
        ';
    }

}

?>
