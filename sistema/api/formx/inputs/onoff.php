<?php

class onoff extends formX_implement{
    
    private 
            $text = null;

    public function __construct($name, $label = NULL, $text = NULL){
        parent::__construct($name, $label);
        $this->text = $text;
        lliure::addDocHead('api/formx/includes/onoff/onoff.css');
    }

    public function form($dados){
        $v = (isset($dados[$this->name]) && $dados[$this->name] == 1);
        $class = ($v? ' on': '');
        $style = ($v? ' style="left: 50%"': '');
        $retorno = 
              '<input type="hidden" name="'.$this->name.'" value="'.$v.'">'
             .'<div class="onoff OnOff-'.$this->name.'">'
                .'<span class="fx_input">ON OFF</span>'
                .'<span class="fx_botao'.$class.'"'.$style.'><div></div></span>'
            .'</div>'
            .'<p class="onoff-p">'.  $this->text.'</p>'
            .'<script type="text/javascript">'
                .'$(".OnOff-'.$this->name.'").click(function(){'                
                    .'if(parseInt($("input[name=\''.$this->name.'\']").val()) == 1){'
                        .'$("input[name=\''.$this->name.'\']").val(0);'
                        .'$("div.OnOff-'.$this->name.' span.fx_botao").removeClass("on").stop().animate({left: 2}, 300);'
                    .'}else{'
                        .'$("input[name=\''.$this->name.'\']").val(1);'
                        .'$("div.OnOff-'.$this->name.' span.fx_botao").addClass("on").stop().animate({left: "50%"}, 300);'
                    .'}'
                .'});'
            .'</script>'
        ;
        return $retorno;
    }

}?>