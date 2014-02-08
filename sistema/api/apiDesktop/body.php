<div class="marginForm">
    <?php
    if (isset($form)){
        echo $form;
    }else{?>
        <h2>Atalho criado com sucesso.</h2>
        <p>Atalho "<?php echo $_POST['nome']?>" foi criado na Home.</p>
        <script>
            setTimeout(function(){
                fechaJfbox();
            }, 2000);
        </script>
        <?php
    }?>
</div>