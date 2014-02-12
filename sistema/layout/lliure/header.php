<?php

lliure::addDocHead('src/imagens/favicon.ico');
lliure::addDocHead('src/css/base.css');

lliure::addDocHead('src/js/jquery.js');
//lliure::addDocHead('api/tiny_mce/tiny_mce.js');
lliure::addDocHead('src/js/jquery-ui.js');
lliure::addDocHead('src/js/funcoes.js');
lliure::addDocHead('src/js/jquery.jfkey.js');
lliure::addDocHead('src/js/jquery.easing.js');
lliure::addDocHead('src/js/jquery.jfbox.js');

lliure::addDocHead(lliure::getPathLayout().'/css/principal.css');
lliure::addDocHead(lliure::getPathLayout().'/css/paginas.css');
lliure::addDocHead(lliure::getPathLayout().'/css/predifinidos.css');
lliure::addDocHead(lliure::getPathLayout().'/css/jfbox.css');
lliure::addDocHead(lliure::getPathLayout().'/css/estilo.css');
lliure::addDocFooter(lliure::getPathLayout().'/js/principal.js');


lliure::header();

?>

<div id="tudo">
	<div id="topo">
		<span class="borda-esquerda"></span>
		<span class="borda-direita"></span>
		<div class="left">
            <a href="" class="logoSistema"><img src="<?php echo lliure::getPathLayout();?>/imagens/blank.gif"/></a>
			<?php
			if(!empty($_GET) && ll_tsecuryt()){
				if(lliure::getModo() == APP){?>
                    <a id="addDesktop" href="apiDesktop/page=<?php echo str_replace('/', ':', lliure::url($_GET));?>" class="addDesktop" title="Adicionar essa página ao desktop">
                        <img src="<?php echo lliure::getPathLayout();?>/imagens/add_desktop.png" alt="" />
                    </a>
					<?php 
				}
			}?>
		</div>
		

		<div class="right">			
			<div class="menu">
				<ul>
					<?php echo 
                        '<li><a href="">Home</a></li>'.
                        '<li><a href="usuario">Minha conta</a></li>'.
                        (ll_tsecuryt('admin') ? '<li><a href="painel">Painel de controle</a></li>' : '').
                        '<li><a href="logof">Sair</a></li>';
					?>					
				</ul>
			</div>
			<?php
			if(ll_tsecuryt('admin')){
				$menuRapido = new start();
                $menu = $menuRapido->lista();
				?>
                <div class="start" id="menu_rapido"  <?php echo start::numRows($menu) == 0 ? 'style="display: none;"' : '' ;?>>
					<div class="width">
						<span class="icone"></span>
						<ul id="appRapido">
							<?php
							while($dados = start::fetch($menu)){?>
								<li id="appR-<?php echo $dados['id']?>">
									<a href="<?php echo $dados['pasta']?>" title="<?php echo $dados['nome']?>">
										<img src="<?php echo APP.DS.$dados['pasta'].DS.'sys'.DS.'ico.png'; ?>" alt="" />
									</a>
								</li>
								<?php
							}?>
						</ul>
					</div>
				</div>
				<?php				
			}?>
		</div>
	</div>

	<div id="conteudo">