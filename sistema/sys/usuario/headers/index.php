<?php

$bar = new apiBar();
$bar->nome('Conta');
$bar->addBottom()
    ->setTitulo(historico::backName())
    ->setHref(historico::backUrl())
    ->setImg('suplimentos/icones/br_prev.png');

$user = new admin();

if(isset($_GET['id']))
    $dados = $user->user($_GET['id']);
else
    $dados = $user->logado();

$form = new formX();

class boi extends formX_implement{
    
    public function form($dados) {
        return 'boi';
    }
    
}

$form
    ->dados($dados)
    ->action('usuario/salvar')
    ->inputHidden('id')
        
    ->fieldset('Dados pessoais')
    ->line(1,1)
        ->texto(NULL, 'Nome <i>(obrigatorio)</i>')
        ->input('nome')
    ->line(1,1)
        ->texto(NULL, 'E-mail')
        ->input('email')

    ->fieldset('Dados de acesso')
    ->line(1,1)
        ->texto(NULL, 'Login <i>(obrigatorio)</i>')
        ->addElement( FALSE,
            new input('login'),
            new inputDisable('login')
        )
    ->line(1,1)
        ->texto(NULL, 'Senha')
        ->password('senha')
    ->line(1,1)
        ->texto(NULL, 'Confirme senha')
        ->password('comfi')
    ->line(1,1)
        ->texto(NULL, 'Grupo de usuário')
        ->select('grupo', NULL, array(
            'Grupos principais' => array(
                'admin' => 'Administrador',
                'user' => 'Usuário',
                'dev' => 'Desenvolvedor'
            )
        ))
        
    ->line(null, 2)
        ->button('Salver', button::ACTION)
        ->aButton('Voltar', historico::backUrl());
        
?>