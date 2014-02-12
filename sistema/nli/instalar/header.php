<?php 

switch (!empty($_GET[1])? $_GET[1]: NULL){

    case 'etapa-1':
        
        lliure::addDocHead('src/js/jquery.validate.js');
        lliure::addDocFooter(lliure::getPathApp(). WS. 'js'. WS. 'etapa1.js');
        
        $form = new formx('form');
        $form
            ->action('instalar')
            ->dados(array(
                'bd-host' => 'localhost',
                'bd-user' => 'root',
                'bd-pfix' => 'll_'
            ))
            ->fieldset()
                ->texto(
                     '<h1>Etapa 1: Banco de Dados</h1>'
                    .'<p>Banco de dados.</p>'
                )
                ->input('bd-host', 'Host')
                ->input('bd-user', 'Usuario')
                ->input('bd-pass', 'Senha', 'password')
                ->input('bd-banc', 'Banco de dados')
                ->input('bd-pfix', 'Prefixo')
                ->linha(2, linha::float_right)
                    ->button('Criar', button::ACTION)
                    ->aButton('Etapa 2', 'instalar/etapa-2');
        
    break; 

    default:

    break;
    
}