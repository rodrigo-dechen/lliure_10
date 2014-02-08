$(function(){
    
    $('#addDesktop').jfbox({width: 450, height: 124}); 

    ll_load('load');
    ll_sessionFix();

    $('#topo .right div.start').mouseenter(function(){		
        var size = $("#appRapido").find("li").size()*52;
        $("#appRapido").css({width: size});

        $(this).stop().animate({width: size+20}, 500, 'easeInOutQuart');
    }).mouseleave(function(){
      $(this).stop().animate({width: '20'}, 500, 'easeInOutQuart');
    });
    
});