<?php

$bar = new apiBar();
$bar->nome('Teste');
$bar->addBottom()
    ->setTitulo(historico::backName())
    ->setHref(historico::backUrl())
    ->setImg('suplimentos/icones/br_prev.png');

$fileup = new fileup();
$fileup
    ->setRotulo('FileUP')
    ->setTitulo('FileUP')
    ->setCampo('fileup')
    ->setExtencao(array('xml', 'png'))
    ->setDiretorio('teste')
    ->setTema(fileup::BUTTON_OUTSIDE_RIGHT);

$form = new formX();
$form
    ->dados(array(
        'fileup' => 'teste.img'
    ))
    ->fieldset('Teste FileUp')
        ->fileup($fileup)
        ->select('select', 'Select', array('teste', 'teste 2'))
        ->numero('numero', 'Numero')
        ->input('teste', 'teste');



?>
