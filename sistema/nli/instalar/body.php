<div id="instalBox">
    <form id="form" action="login" method="post">
        <input type="hidden" name="token" value="<?php echo token::novo();?>">
        <fieldset>
            <div>
                <h1>Ola!</h1>
                <p>Bem vindo.</p>
            </div>
        </fieldset>
        <span class="botao"><a href="instalar/etapa-1">Iniciar</a></span>
    </form>
    <div class="both"></div>
</div>