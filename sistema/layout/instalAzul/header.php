<?php

lliure::addDocHead('src/imagens/favicon.ico');
lliure::addDocHead('src/css/base.css');

lliure::addDocHead('src/js/jquery.js');
lliure::addDocHead('src/js/funcoes.js');

lliure::addDocHead(lliure::getPathLayout(). WS. 'css'. WS. 'instal.css');

lliure::header();?>
    <div id="instal">
        <img src="<?php echo lliure::getPathLayout(), DS, 'imagens', DS, 'logo.png';?>" class="logo" alt="lliure" />