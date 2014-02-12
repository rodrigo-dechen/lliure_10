$('#form').validate({
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
        return false;
    }
}).submit(function(){
    return false;
});