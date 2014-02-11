<div id="instalBox">
     <form id="form" action="instalar" method="post">
        <?php switch (!empty($_GET[1])? $_GET[1]: NULL){
            
            case 'etapa-1':?>
                <fieldset>
                    <div>
                        <h1>Etapa 1: Banco de Dados</h1>
                        <p>Banco de dados.</p>
                    </div>
                    <div>
                        <label>Host</label>
                        <input type="text" name="bd-host" value="localhost"/>
                    </div>
                    <div>
                        <label>Login</label>
                        <input type="text" name="bd-user" value="root"/>
                    </div>
                    <div>
                        <label>Senha</label>
                        <input type="password" name="bd-pass"/>
                    </div>
                    <div>
                        <label>Banco de dados</label>
                        <input type="text" name="bd-banc"/>
                    </div>
                    <div>
                        <label>Prefixo</label>
                        <input type="text" name="bd-pfix" value="ll_"/>
                    </div>
                    <div>
                        <span class="botao">
                            <button type="submit">Criar</button>
                        </span>
                    </div>
                </fieldset>
            <?php break;?>

            <?php default:?>
                <fieldset>
                    <div>
                        <h1>Ola!</h1>
                        <p>Bem vindo.</p>
                    </div>
                    <div>
                        <span class="botao"><a href="instalar/etapa-1">Iniciar</a></span>
                    </div>
                </fieldset>
             <?php break; ?>

        <?php }?>
    </form>
    <div class="both"></div>
</div>