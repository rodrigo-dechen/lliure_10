<?php
/**
 * Description of aButton
 *
 * @author Rodrigo
 */

class jsButton extends formX_implement{

    const
    ACTION = 0;
    
    static private 
    $actions = array(
        'fp_action'
    );
    
    public
    $action,
    $attrs;

    public function __construct($name, $script, array $attrs = array(), $modo = -1){
        parent::__construct($name);
        $this->action = $modo;
        lliure::addDocFooter($script);
        $this->attrs = $attrs;
    }

    public function form($dados){
        $action = (!array_key_exists($this->action, self::$actions)? '' : ' '.(self::$actions[$this->action]));
        
        $attrs = '';
        foreach($this->attrs as $chave => $valor)
            $attrs .=  ' ' . $chave . '="' . $valor . '"';
        
        return '
            <span class="fp_botao' . $action . '"><div' . $attrs . '>' . $this->name . '</div></span>';
    }

}

?>