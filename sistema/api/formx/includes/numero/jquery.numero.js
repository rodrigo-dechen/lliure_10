(function($){
    $.fn.numero = function( options ){
 
        var dados = $.extend({
            defaut: 0,
            step: 1,
            min: null,
            max: null,
            span: null,
            up: null,
            down: null
        }, options );
 
        return this.each(function (){
            var input = this;
            muneroSetVal(input, dados.span, dados.min, dados.max, dados.defaut);
            $(dados.up).click(function (){
                muneroChangeVal(input, dados.span, dados.min, dados.max, dados.step);
                return false;
            });
            $(dados.down).click(function (){
                muneroChangeVal(input, dados.span, dados.min, dados.max, ((-1) * dados.step));
                return false;
            });
        });
    };
}(jQuery));

function muneroSetVal(input, span, min, max, val){
    $(input).val(val);
    $(span).text(val);
    numeroValida(input, span, min, max);
}

function muneroChangeVal(input, span, min, max, val){
    muneroSetVal(input, span, min, max, parseInt($(input).val()) + val);
}

function numeroValida(input, span, min, max){
    if (min !== null && parseInt($(input).val()) < min){
        muneroSetVal(input, span, min, max, min);
    }
    if (max !== null && parseInt($(input).val()) > max){
        muneroSetVal(input, span, min, max, max);
    }
}