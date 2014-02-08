<?php

class autoLoad{
    
    static private

    /**
     * array com os caminhos que o auto load procura
     */
    $path = array(),

    /**
     * array com os functions que o auto load executa
     */
    $functions = array();
    
    public static function setPath($path){

        $basePath = realpath(__DIR__.DS.'..'.DS.'..'.DS.$path);
        $corte = strlen(realpath(__DIR__.DS.'..'.DS.'..')) - strlen($basePath) + 1;
        $path = $corte < 0? substr($basePath, $corte): NULL;
        
        if ($path !== NULL && !in_array($path, self::$path))
            self::$path[] = $path;
    }
    
    public static function setFunction($function){
        if (is_callable($function))
            self::$functions[] = $function;
    }

    public static function getFile($nome){
        
        $retorno = null;
        
        foreach (self::$functions as $function){
            $arquivo = realpath(__DIR__.DS.'..'.DS.'..'.DS.$function($nome, self::$path));
            if (is_file($arquivo)){
                $retorno = $arquivo;
                break;
            }
        }
        
        if ($retorno !== NULL)
            return $retorno;
        else
            throw new Exception('Erro do AutoLoad', 0);
    }

}

spl_autoload_register(function ($nome){
    try {
        require_once autoLoad::getFile($nome);
    } catch (Exception $exc) {
        return NULL;
        //echo $exc->getMessage();
    }
});