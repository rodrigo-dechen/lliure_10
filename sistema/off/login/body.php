<div id="login">
    
    <img src="<?php echo lliure::getPathLayout(), DS, 'imagens', DS, 'logo.png';?>" class="logo" alt="lliure" />
    
    <?php
    switch (isset($_GET['erro'])? $_GET['erro']: null){
    case 'login':
        echo '<span class="mensagem">Login não encontrado. Tente novamente</span>';
        break;
    case 'senha':
        echo '<span class="mensagem">Senha errada para este Usuário. Tente novamente</span>';
        break;
    case 'preen':
        echo '<span class="mensagem">Preencha todos os Campos. Tente novamente</span>';
        break;
    }?>

    <div id="loginBox">
        <form id="form" action="login" method="post">
            <input type="hidden" name="token" value="<?php echo token::novo();?>">
            <fieldset>
                <div>
                    <label>Usuário</label>
                    <input type="text" name="usuario" class="user" autocomplete="off" />
                </div>

                <div>
                    <label>Senha</label>
                    <input type="password" name="senha" />
                </div>
            </fieldset>
            <span class="botao"><button type="submit">Entrar</button></span>
        </form>
        <div class="both"></div>
    </div>
</div>	

<?php 
if(isset($_GET['erro'])){
    lliure::addDocFooter(lliure::getPathLayout().DS.'js'.DS.'erro.js');
}else{
    lliure::addDocFooter(lliure::getPathLayout().DS.'js'.DS.'ok.js');
}
?>