<?php
/**
 * Description of js
 *
 * @author Rodrigo
 */

class jf {
    
    private static 

    /**
     * Garda o ultomo id inserido.
     */
    $ultimo_id = null;

    public static function ultimo_id(){
        return self::$ultimo_id;
    }

    /**
     * //Descrição
     * jf_insert(string $tabela, array $dados)
     * monta e execulta uma query de insert em mysql	
     * 
     * // Parametros
     * $table
     * nome da tabela que estará sendo feito o insert
     * $dados
     * Dados que serão inseridos na tabela em forma de array.
     * Esse array pode ter dois formatos diferentes.
     * 
     * Primero formato, insert simples.
     * $dados = array(
     *     'coluna'  => 'dado',
     *     'coluna2' => 'dado2'
     * );
     * 
     * Segumdo formato, multi inserr.
     * 
     * $dados = array(
     *     array(
     *         'coluna'  => 'dado',
     *         'coluna2' => 'dado2'
     *     ),
     *     array(
     *         'coluna'  => 'dado3',
     *         'coluna2' => 'dado4'
     *     )
     * );
     * 
     * // Retorno
     * retorna o erro na execução da query,
     * - Caso sejá executada com sucesso o retorno será null
     * - Caso não sejá possivel execultar a query, retorna a query seguinda do erro
     * 
     */
    public static function insert($tabela, $dados, $print = false){
	
	
        $return = null;

        $chaves = array_keys($dados);

        if (is_array($dados[$chaves[0]])){

            $colunas = null;
            foreach($dados as $chave => $valor){
                foreach($valor as $chave1 => $valor1){
                    $colunas [$chave1] = '`'.$chave1.'`';
                }
            }

            $valores = '';
            foreach($dados as $chave => $valor){
                $unicValores = '';
                foreach($colunas as $coluna){
                    $unicValores .= (empty($unicValores)? '': ', ') . (isset($valor[$coluna]) && $valor[$coluna] != null && $valor[$coluna] != 'null' && $valor[$coluna] != 'NULL'? '"' . addslashes($valor[$coluna]) . '"': 'NULL');
                }
                $valores .= (empty($valores)? '': ', ') . '(' . $unicValores . ')';
            }

            $colunas = implode(', ', $colunas);

        }else{

            $valores = '';
            $colunas = '';
            foreach($dados as $chave => $valor){
                $valor = ($valor != 'NULL' ? '"'.addslashes($valor).'"' : 'NULL');
                $valores .= (empty($valores)? '' : ', ').$valor;
                $colunas .= (empty($colunas)? '' : ', ').$chave;
            }
            $valores = '(' . $valores . ')';

        }


        $executa = 'INSERT INTO ' . $tabela . ' (' . $colunas . ') values ' . $valores;
        if(mysql_query($executa) != false){
            
            global $ml_ultmo_id;
            global $jf_ultimo_id;

            self::$ultimo_id = mysql_insert_id();
            
            $jf_ultimo_id = self::$ultimo_id;
            $ml_ultmo_id = self::$ultimo_id;

        } else {
            $return = '<strong>Query:</strong> '.htmlentities($executa).'  <strong>Erro:</strong> '.htmlentities(mysql_error());
        }

        if($print)
            $return = $executa;

        return $return;
    }
    
    /**
     *  EXPLICANDO *********************************
     * $table = "nome_da_tabela";
     * $dados = array(
     *     'coluna' 	=>	'dados',
     *     'coluna2' 	=>	'dados2'
     * );
     * 
     * $alter = $alter['coluna'] = "Valor";
     * 
     * $mod = ">" ou "<" ou "like" caso nenhum o padrão é "="
     * 
     * para setar um valor como NULL é só enviar NULL, valores vazios não faram parte da query
     * 
     * // Retorno
     * retorna o erro na execução da query,
     * - Caso sejá executada com sucesso o retorno será null
     * - Caso não sejá possivel execultar a query, retorna a query seguinda do erro
     */
    public static function update($tabela, $dados, $alter, $mod = null, $print = false){
        
        $return = null;
        $valores = '';
        foreach($dados as $chaves => $valor){
            $valor = ($valor != 'NULL' ? '"'.addslashes($valor).'"' : 'NULL');
            $valores .= (empty($valores)?' ':', ').'`'.$chaves.'` = '.$valor;
        }

        $where = '';
        $operador = is_null($mod) || $mod ? "=" : $mod ;	
        foreach($alter as $chave => $valor){
            $where .= (!empty($where) ? ' and ' : '' ) . $chave . ' ' . $operador . ' "' . $valor. '" ';
        }

        $executa = 'UPDATE '.$tabela.' Set '.$valores.' where '.$where;

        if(mysql_query($executa) == false){
            $return = '<strong>Query:</strong> '.htmlentities($executa).'  <strong>Erro:</strong> '.htmlentities(mysql_error());
        }

        if($mod === true || $print == true)
            $return = $executa;

        return $return;
    }
    
    /**
     * 
     * 
     * // Retorno
     * retorna o erro na execução da query,
     * - Caso sejá executada com sucesso o retorno será null
     * - Caso não sejá possivel execultar a query, retorna a query seguinda do erro
     */
    public static function delete($tabela, $alter, $print = false){

        $del = '';
        if (is_array($alter)){
            foreach($alter as $chave => $valor){
                if(!empty($del))
                    $del .= ' and ';

                $del .= $chave.' = "'.$valor.'"';
            }
        }elseif (is_string($alter)){
            $del = $alter;
        }

        $executa = 'DELETE FROM '.$tabela.' where '.$del;	

        $retorno = null;
        if(mysql_query($executa) != false){
            $retorno = null;
        }elseif (mysql_errno() !== 0){
            $retorno = '<strong>Query:</strong> '.htmlentities($executa).'  <strong>Erro:</strong> '.htmlentities(mysql_error()).'';
        }elseif ($alter === true || $print) {
            $retorno = $executa;
        }
        return $retorno;

    }
    
    public static function select($query, $print = FALSE){
        $retorno = mysql_query($query);
        
        if (mysql_errno() !== 0)
            $retorno = '<strong>Query:</strong> '.htmlentities($query).'  <strong>Erro:</strong> '.htmlentities(mysql_error()).'';
        
        if ($print)
            lliure::pre($query);
        
        return $retorno;
    }
    
    public static function fetch($resource){
        return mysql_fetch_assoc($resource);
    }
    
}

?>