<?php
/**
 * Description of token
 *
 * @author Rodrigo
 */

class token {
    
    public static function teste($token){
        return (isset($_SESSION['ll']['token']) && $_SESSION['ll']['token'] == $token);
    }
    
    public static function exibe(){
        return (isset($_SESSION['ll']['token'])? $_SESSION['ll']['token']: FALSE);
    }
    
    public static function novo(){
        $token = uniqid(md5(rand()));
        $_SESSION['ll']['token'] = $token;
        return $token;
    }

}

?>
