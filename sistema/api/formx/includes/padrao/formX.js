$(function(){
    $('.formPadrao .fp_linha').click(function(){
        $('.formPadrao .fp_linha').css({zIndex: 0})
        $(this).css({zIndex: 1});
        //alert('aqui');
    });
});