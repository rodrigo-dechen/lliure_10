$('#form').validate({
    rules:{
        'bd-host' : "required",
        'bd-user' : "required",
        'bd-banc' : "required",
        'bd-pfix' : "required"
    },
    messages:{
        'bd-host' : "Obrigatório pasar o endereço do banco",
        'bd-user' : "Obrigatório pasar um usuário do banco",
        'bd-banc' : "Obrigatório pasar o nome do banco",
        'bd-pfix' : "Obrigatório pasar um prefixo para os nomes das tabelas"
    },
    submitHandler: function(form){
        return false;
    }
}).submit(function(){
    return false;
});