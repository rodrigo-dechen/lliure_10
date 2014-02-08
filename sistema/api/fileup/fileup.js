$('.fileup_botao').click(function(){
    $(this).closest('div').find('.fileup_file').click();	
});

$('.fileup_file').change(function(){
    
    var base = $(this).closest('div');
    var DS = $(this).val().lastIndexOf('/') >= 0 ? '/': '\\';
    var arquivo = $(this).val().split(DS).pop();
    var extencao = arquivo.split('.').pop().toLowerCase();
    var extencoes = $('.fileup_extencao', base).val().toLowerCase();
    var extencoes = (extencoes.length > 0? extencoes.split(' '): null);
    
    if(extencoes === null || fileup_exten(extencao, extencoes) !== false){
        $('.fileup_nome', base).html(arquivo);
    } else {
        jfAlert('Tipo de arquivo não permitido');
        $('.fileup_nome', base).html('');
        var input = $('<input>', {
            class:  $(this).attr('class'),
            name:   $(this).attr('name'),
            type:   $(this).attr('type')
        });
        $(this).remove();
        $(base).prepend(input);
    }
    
});

function fileup_exten(needle, haystack){
    for (var chave in haystack){
        if (haystack[chave] == needle)
            return chave;
    }
    return false;						
}
