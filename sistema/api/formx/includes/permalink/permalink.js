function formata_url(id, rel){
    var texto = $(rel).val().toString();
    
    console.log(texto.indexOf('&Agrave'));
    
    texto = texto.toLowerCase();
    texto = texto.replace(/[באגד×]/g,"a");
    texto = texto.replace(/[יטך]/g,"e");
    texto = texto.replace(/[םלמן]/g,"i");
    texto = texto.replace(/[ףעפץ÷]/g,"o");
    texto = texto.replace(/[ףעפץ÷]/g,"o");
    texto = texto.replace(/[תשû]/g,"u");
    texto = texto.replace(/ח/g,"c");
    //texto = texto.replace(/[^ a-z 0-9 \t _ \/ -]/g,"");
    texto = texto.replace(/[ ]/g,"-");
    $('input.'+id).val(texto);
    $('span.'+id).html(texto);
}
