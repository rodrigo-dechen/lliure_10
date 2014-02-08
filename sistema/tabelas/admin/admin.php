<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of admin
 *
 * @author Rodrigo
 */
class admin extends db{
    
    public function __construct(){
        parent::__construct(PREFIXO.'lliure_admin');
    }
    
    public function user($id){
        $sql = 'SELECT * FROM '. $this->tabela . ' WHERE id = "' . $id . '" LIMIT 1 ;';
        $result = $this->select($sql);
        return self::fetch($result);
    }
    
    public function logado(){
        return $this->user($_SESSION['ll']['user']['id']);
    }
    
    public function salvar(array $dados){
        $this->update($dados, 'id="[id]"');
    }
    
    public function testaUser($login, $senha){
        
        $login = admin::antiInjection($login);
        $forFile = FALSE;
        
        /*
         * sesativado por arquivo.
        if(isset(lliure::llconf()->senhaDev)){

            $senhaDev = trim(isset(lliure::llconf()->senhaDev->senha) ? lliure::llconf()->senhaDev->senha : $this->llconf->senhaDev);
            $usuarioDev = isset(lliure::llconf()->senhaDev->usuario) ? lliure::llconf()->senhaDev->usuario : 'dev';

            if($login == $usuarioDev){
                if(($senhaDev = @file_get_contents($senhaDev)) != false){

                    $senhaDev = trim($senhaDev);							
                    $senha = md5($_POST['senha']);

                    if($senhaDev == $senha){
                        $forFile = TRUE;
                        $dados = array(
                            'id' => '0',
                            'nome' => 'Desenvolvedor',
                            'grupo' => 'dev',
                            'tema' => 'default'
                        );
                    }
                }
            }
        }
         * 
         */
        
        if (!isset($dados)){
            $senha = md5($_POST['senha'].'0800');

            $sql = '
                SELECT
                    a.id, if((SELECT true FROM '.$this->tabela.' b WHERE b.id =  a.id  and b.senha = "'.$senha.'" LIMIT 1) is not null, true, false) as senha
                FROM
                    (
                        SELECT
                            if((SELECT true FROM '.$this->tabela.' c WHERE c.login = "dev" LIMIT 1) is not null, (SELECT id FROM '.$this->tabela.' d WHERE d.login = "'.$login.'" LIMIT 1), null) as id
                    ) as a

                LIMIT
                    1
            ';
            echo $sql;
            $dados = $this->select($sql)[0];
        }
        
        if ($dados['id'] === NULL)
            throw new Exception ('Login nao existe.', 0);
        elseif (!$dados['senha'])
            throw new Exception ('Senha incorreta.', 1);
        else{
            if ($forFile)
                return $dados;
            else
                return $this->user($dados['id']);
        }

    }
    
}

?>
