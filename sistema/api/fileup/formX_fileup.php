<?php
/**
 * Description of formX
 *
 * @author Tiago
 */

class formX_fileup extends formX_implement{
    
    private $fileUp;

    public function __construct($fileup){
        $this->fileUp = $fileup;
    }

    public function form($dados) {
        $this->fileUp->setRegistro(isset($dados[$this->fileUp->getCampo()])? $dados[$this->fileUp->getCampo()]: $this->fileUp->getRegistro());
        return (string) $this->fileUp;
    }
}

?>
