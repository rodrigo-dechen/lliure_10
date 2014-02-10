<?php

lliure::addDocHead('suplimentos/imagens/favicon.ico');
lliure::addDocHead('suplimentos/css/base.css');

lliure::addDocHead('suplimentos/js/jquery.js');
lliure::addDocHead('suplimentos/js/funcoes.js');

lliure::addDocHead(lliure::getPathLayout(). WS. 'css'. WS. 'instal.css');

lliure::header();?>
    <div id="instal">
        <img src="<?php echo lliure::getPathLayout(), DS, 'imagens', DS, 'logo.png';?>" class="logo" alt="lliure" />