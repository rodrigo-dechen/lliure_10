<?php
if(isset($_GET['page'])){

    lliure::setLayoutOff();
    lliure::addDocHead(lliure::getPathApp().DS.'estilo.css');

    $e = explode(':', $_GET['page']);
    $app = reset($e);
    $dados = array('link' => implode('/', $e), 'imagem' => APP.'/'.$app.'/sys/ico.png');

    $form = new formX(NULL, 'jfbox');
    $form
        ->action('apiDesktop')
        ->dados($dados)
        ->inputHidden('link')
        ->inputHidden('imagem')
        ->fieldset('Nome desta página.')
            ->input('nome')
            ->line(NULL, 2, line::FLOAT_RIGHT)
                ->button('Criar', button::ACTION)
                ->jsButton('Cancelar', lliure::getPathApp().DS.'cancelar.js', array('id' => 'canselarDesktop'));

}elseif (!empty($_POST)){
    
    lliure::setLayoutOff();
    $desktop = new desktop();
    $desktop->insert($_POST);
    
}else{
    lliure::setHtmlOff();
    header('Location: '. URLREAL);
}

?>