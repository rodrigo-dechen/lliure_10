<?php
/**
 * Description of desktop
 *
 * @author Rodrigo
 */
class desktop extends db{
    
    public function __construct() {
        parent::__construct(PREFIXO . 'lliure_desktop');
    }
    
    public function insert(array $dados){
        return parent::insert($dados);
    }
    
    public function lista(){
        return $this->select('SELECT * FROM ' . $this);
    }
    
    public function update(array $dados, $where = NULL) {
        parent::update($dados, $where);
    }
    
}

?>
