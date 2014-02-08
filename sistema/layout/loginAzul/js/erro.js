$(function(){
        
    $('.user').focus();
    
    var tempo = 150;
    var left = -50;
    var right = 50;

    $("#loginBox").animate({
        left: right+"px"
    },tempo, function() {
        $(this).animate({
            left: left+"px"
        },tempo, function() {
          $(this).animate({
                left: right+"px"
            },tempo-50, function() {
                $(this).animate({
                    left: left+"px"
                },tempo-50, function() {
                    $(this).animate({
                        left: "0px"
                    },tempo-50);
                });
            });
        });
    });
});


