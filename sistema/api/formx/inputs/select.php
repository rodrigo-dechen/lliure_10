<?php
/**
 * Description of select
 *
 * @author Rodrigo
 */

class select extends formX_implement{

    private
        $options;

    public function __construct($name, $label = null, array $options = array()) {
        parent::__construct($name, $label);
        $this->options = $options;
        //lliure::addDocHead('api/formX/includes/select/select.css');
    }
    
    public function form($dados){

        $quem = (isset($dados[$this->name])? $dados[$this->name]: NULL);
        
        if ($quem === NULL){
            $quem = array_keys($this->options);
            $quem = array_shift($quem);
        }
        
        $retorno = '';

        foreach ($this->options as $chave => $valor)
            $retorno .= '
                <option value="' . $chave . '"'.($quem == $chave? ' selected': '').'>' . $valor . '</option>';

        /*$retorno = '
            <div class="persoSelect">
                <span class="fx_input select_'.$this->name.'">'.($this->options[$quem]).'</span>
                <span class="fx_botao"><button class="select_'.$this->name.'"><span class="seta baixo"></button></a></span>
                <select class="fx_select" name="' . $this->name . '" size="2">'.
                     $retorno.
                '</select>
            </div>
            <script type="text/javascript">
                $(function(){
                    var maxOption = 10;
                    var sub = {1: 0, 2: 0, 3: 1, 4: 1.5, 5: 1.8, 6: 2, 7: 2.15, 8: 2.25, 9: 2.333, 10: 2.4}
                    var option = $(\'select[name="'.$this->name.'"] option\').length;
                    option = option > maxOption? maxOption: option;
                    var height = parseInt(option * (20 - sub[option]));
                    $(\'select[name="'.$this->name.'"]\').height(height);
                });

                $(".select_'.$this->name.'").click(function(){
                    $(\'select[name="'.$this->name.'"]\').show().focus();
                    return false;
                });
                
                $(\'select[name="'.$this->name.'"]\').change(function(){
                    var select = this;
                    $("span.select_'.$this->name.'").text($("option:selected", select).text());
                    $(select).click(function(){
                        $(select).focusout();
                    });
                    return false;
                }).focusout(function(){
                    $(this).hide();
                    return false;
                });
            </script>
        ';*/
        
        $retorno = 
            '<select class="fx_select" name="' . $this->name . '">'.
                 $retorno.
            '</select>'
        ;

        return $retorno;
    }

}