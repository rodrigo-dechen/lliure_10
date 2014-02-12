<?php
/**
 * Description of aButton
 *
 * @author Rodrigo
 */

class jsButton extends formX_implement{

    static 
        $ACTION = 0;
    
    static private 
        $actions = array(
            'fx_action'
        );
    
    public
        $url, $action;

    public function __construct($name, $action = -1){
        parent::__construct($name);
        $this->url = $url;
        $this->action = $action;
    }

    public function form($dados){
        $action = (!array_key_exists($this->action, self::$actions)? '' : ' '.(self::$actions[$this->action]));
        
        return '
            <span class="fx_botao' . $action . '"><div>' . $this->name . '</div></span>';
    }

}

?>