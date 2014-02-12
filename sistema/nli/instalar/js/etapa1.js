$('#form').validate({
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
        return false;
    }
}).submit(function(){
    return false;
});