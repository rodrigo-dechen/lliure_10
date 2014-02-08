<?php

$erro = '';

if ($_POST['senha'] == $_POST['comfi']){
    
    unset($_POST['comfi']);
    if (empty($_POST['senha']))
        unset($_POST['senha']);
    else
        $_POST['senha'] = md5($_POST['senha'].'0800');

    $user = new admin();
    $user->salvar($_POST);

}else{
    $erro = '/erro=senha';
}

lliure::setHtmlOff();
header('Location: ' . URLREAL . 'usuario' . ($_POST['id'] != $_SESSION['ll']['user']['id']? '/id='.$_POST['id']: '') . $erro);

?>