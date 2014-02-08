<?php
/**
 * Description of historico
 *
 * @author Rodrigo
 */

class historico {

    public static function reinicia(){
        unset($_SESSION['ll']['historico']);
        $_SESSION['ll']['historico'][0] = lliure::url($_GET);
    }

    public static function retroceder($return = 1){
        if (isset($_SESSION['ll']['historico'])){
            $total = count($_SESSION['ll']['historico']);
            $fim = $total - $return;
            $fim = $fim < 0? 0: $fim;
            for($i = $total; $i > $fim; $i--)
                array_pop($_SESSION['ll']['historico']);
        }
    }

    public static function backUrl(){
        $i = count($_SESSION['ll']['historico']) - 2;
        if ($i >= 0)
            return $_SESSION['ll']['historico'][$i];
        else
            return 'index';
    }

    public static function backName(){
        $i = count($_SESSION['ll']['historico']) - 1;
        if ($i > 0)
            return "Voltar";
        else
            return "Voltar à área de trabalho";
    }
    
}

?>
