<?php
/**
 * Description of start
 *
 * @author Rodrigo
 */

class start extends db{
        
    public function __construct() {
        parent::__construct(PREFIXO.'lliure_start');
    }
    
    public function lista(){
        return $this->select('
            SELECT
                b.*
            FROM
                '.$this->tabela.' a

                LEFT JOIN
                    '.PREFIXO.'lliure_plugins b
                ON
                    a.idPlug = b.id
        ');
    }
    
}

?>
