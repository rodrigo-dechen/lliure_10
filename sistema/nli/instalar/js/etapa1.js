var validate = $('#form').validate({
    rules:{
        'bd-host' : "required",
        'bd-user' : "required",
        'bd-banc' : "required",
        'bd-pfix' : "required"
    },
    messages:{
        'bd-host' : "Obrigatório passar o endereço do banco",
        'bd-user' : "Obrigatório passar um usuário do banco",
        'bd-banc' : "Obrigatório passar o nome do banco",
        'bd-pfix' : "Obrigatório passar um prefixo para os nomes das tabelas"
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
                    //posivelmente este endereço esta errado!
                    validate.showErrors({
                        'bd-host' : "Este endereço não coresponde a um serviço de banco de dados."
                    });
                }else if(retorno.code == 1044){
                    //usuario esta errado
                    validate.showErrors({
                        'bd-user' : "Posivelmemte este usuario não existe, ou nao tem altorisaço de usso da tabela."
                    });
                }else if(retorno.code == 1045){
                    //usuario esta errado
                    validate.showErrors({
                        'bd-pass' : "Posivelmemte a senha esta errada."
                    });
                }else if(retorno.code == 1049){
                    //usuario esta errado
                    validate.showErrors({
                        'bd-banc' : "Este bamco não existe."
                    });
                }
                
            }
        });
    
        return false;
    }
});