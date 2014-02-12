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
        $this->referencia = $referencia;
        lliure::addDocHead('api/formx/includes/permalink/permalink.js');
    }

    public function form($dados) {
        return '
            <span class="fx_input permaLink_'.$this->name.'" disabled="disabled" ></span>
            <input class="permaLink_'.$this->name.'" type="hidden" name="'.$this->name.'" />
            <script>
                $(function(){
                    formata_url("permaLink_'.$this->name.'", "input[name='.$this->referencia.']");
                    $("input[name=' . $this->referencia . ']").keyup(function(){
                        formata_url("permaLink_' . $this->name . '", "input[name=' . $this->referencia . ']");
                    })
                });
            </script>
        ';
    }
    
}

?>
