function formata_url(id, rel){
    var texto = $(rel).val().toString();
    
    console.log(texto.indexOf('&Agrave'));
    
    texto = texto.toLowerCase();
    texto = texto.replace(/[����]/g,"a");
    texto = texto.replace(/[���]/g,"e");
    texto = texto.replace(/[����]/g,"i");
    texto = texto.replace(/[�����]/g,"o");
    texto = texto.replace(/[�����]/g,"o");
    texto = texto.replace(/[���]/g,"u");
    texto = texto.replace(/�/g,"c");
    //texto = texto.replace(/[^ a-z 0-9 \t _ \/ -]/g,"");
    texto = texto.replace(/[ ]/g,"-");
    $('input.'+id).val(texto);
    $('span.'+id).html(texto);
}
