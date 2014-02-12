<?php
/**
 * Description of button
 *
 * @author Rodrigo
 */

class button extends formX_implement{
    
    const 
    ACTION = 0;
    
    static private 
    $actions = array(
        'fp_action'
    );
            
    public
        $type, $action;

    public function __construct($name, $action = -1, $type = 'submit'){
        parent::__construct($name);
        $this->type = $type;
        $this->action = $action;
    }

    public function form($dados){
        $action = (!array_key_exists($this->action, self::$actions)? '' : ' '.(self::$actions[$this->action]));
        
        return '
            <span class="fp_botao' . $action . '"><button type="' . $this->type . '">' . $this->name . '</button></span>';
    }

}

?>
