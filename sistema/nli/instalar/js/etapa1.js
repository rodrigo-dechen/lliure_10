var validate = $('#form').validate({
    rules:{
        'bd-host' : "required",
        'bd-user' : "required",
        'bd-banc' : "required",
        'bd-pfix' : "required"
    },
    messages:{
        'bd-host' : "Obrigat�rio passar o endere�o do banco",
        'bd-user' : "Obrigat�rio passar um usu�rio do banco",
        'bd-banc' : "Obrigat�rio passar o nome do banco",
        'bd-pfix' : "Obrigat�rio passar um prefixo para os nomes das tabelas"
    },
    submitHandler: function(form){

        $.ajax({
            type: "POST",
            url: 'instalar/etapa-1',
            data: $(form).serialize(),
            dataType: 'json',
            success: function(retorno){
                console.log(retorno);
                
                if(retorno.code == 2002){
                    //posivelmente este endere�o esta errado!
                    validate.showErrors({
                        'bd-host' : "Este endere�o n�o coresponde a um servi�o de banco de dados."
                    });
                }else if(retorno.code == 1044){
                    //usuario esta errado
                    validate.showErrors({
                        'bd-user' : "Posivelmemte este usuario n�o existe, ou nao tem altorisa�o de usso da tabela."
                    });
                }else if(retorno.code == 1045){
                    //usuario esta errado
                    validate.showErrors({
                        'bd-pass' : "Posivelmemte a senha esta errada."
                    });
                }else if(retorno.code == 1049){
                    //usuario esta errado
                    validate.showErrors({
                        'bd-banc' : "Este bamco n�o existe."
                    });
                }
                
            }
        });
    
        return false;
    }
});