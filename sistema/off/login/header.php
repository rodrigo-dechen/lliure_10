<?php

if (!empty($_POST)){

    if((!empty($_POST['usuario'])) && (!empty($_POST['senha'])) && token::teste($_POST['token'])){

        lliure::setHtmlOff();

        $user = new admin();
        try {
            $dadosLogin = $user->testaUser($_POST['usuario'], $_POST['senha']);
            
            //$tema_default = isset($llconf->defaultThemer)? $llconf->defaultThemer: $this->defaultThemer;
            
            $tema_default = 'lliure';

            if($dadosLogin['themer'] == 'default')
                $dadosLogin['themer'] = $tema_default;
            elseif(file_exists('layout'.DS.$dadosLogin['themer']) == false)
                $dadosLogin['themer'] = $tema_default;

            $_SESSION['ll']['user'] = array(
                'id' => $dadosLogin['id'],
                'nome' => $dadosLogin['nome'],
                'grupo' => $dadosLogin['grupo'],
                'tema' => $dadosLogin['themer'],
                'token' => token::novo()
            );

            header('location: ' . URLREAL);

        } catch (Exception $exc) {
            if($exc->getCode() == 0)
                header('location: ' . URLREAL . 'login/erro=login');
            elseif($exc->getCode() == 1)
                header('location: ' . URLREAL . 'login/erro=senha');
        }

    }else{
        header('location: ' . URLREAL . 'login/erro=preen');
    }
}

?>