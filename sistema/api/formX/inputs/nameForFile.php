<?php
/**
 * Description of nameForFile
 *
 * @author Rodrigo
 */

class nameForFile extends formX_implement{
    
    static $id = 0;
    public
        $meuId,
        $referencia;

    public function __construct($name, $label = null, $referencia = null) {
        parent::__construct($name, $label);
        $this->meuId = self::$id;
        self::$id++;
        $this->referencia = $referencia? $referencia: $name;
        lliure::addDocHead('api/formX/includes/nameForFile/nameForFile.js');
    }

    public function form($dados){
        return '
            <input class="nameForFile_' . $this->meuId . '" name="' . $this->name . '" type="hidden" '.$this->getValueStandard($this->name, $dados).'/>
            <input id="nameForFile_' . $this->meuId . '" class="fp_input" type="text" '.$this->getValueStandard($this->name, $dados).' disabled/>
            <script>
                $(function(){
                    nameForFile("nameForFile_' . $this->meuId . '", "input[name=' . $this->referencia . ']");
                    $("input[name=' . $this->referencia . ']").keyup(function(){
                        nameForFile("nameForFile_' . $this->meuId . '", "input[name=' . $this->referencia . ']");
                    })
                });
            </script>';
    }
    
}

?>
