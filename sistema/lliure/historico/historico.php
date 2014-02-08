<?php
/**
 * Description of historico
 *
 * @author Rodrigo
 */

class historico {
    
    private static function iniciar(){

        if($_GET[0] != 'index'){
            $pageatual = lliure::url($_GET);

            if(isset($_SESSION['ll']['historico']) && !empty($_SESSION['ll']['historico'])){
                $count = count($_SESSION['ll']['historico']);
                if($count > 1 && $pageatual === $_SESSION['ll']['historico'][$count-2]){
                    array_pop($_SESSION['ll']['historico']);
                }elseif($pageatual !== $_SESSION['ll']['historico'][$count-1]){
                    $_SESSION['ll']['historico'][] = $pageatual;
                }
            } else {
                $_SESSION['ll']['historico'][0] = $pageatual;
            }

        } else {
            if(isset($_SESSION['ll']['historico'])){
                unset($_SESSION['ll']['historico']);
            }
        }

        return true;

    }

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
