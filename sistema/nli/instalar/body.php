<div id="instalBox">
    <?php switch (!empty($_GET[1])? $_GET[1]: NULL){

        case 'etapa-1': 

            echo $form;

        break;

        default:?>
            <form id="form" class="formX" action="instalar" method="post">
                <fieldset>
                    <div>
                        <h1>Ola!</h1>
                        <p>Bem vindo.</p>
                    </div>
                    <div>
                        <span class="botao"><a href="instalar/etapa-1">Iniciar</a></span>
                    </div>
                </fieldset>
            </form>
         <?php break; ?>
    <?php }?>
    <div class="both"></div>
</div>