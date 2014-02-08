/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function nameForFile(id, ref) {
    //palavras para ser ignoradas
    var str = $(ref).val();
    var getWords = function(str) {
        return str.match(/\S+\s*/g);
    };
    $('#' + id).each(function () {
        if ($.trim(str).length > 0){
            var words = getWords(str);
            $.each(words, function (i){
                if (i > 0){
                    words[i] = $.trim(words[i].charAt(0).toUpperCase() + words[i].slice(1).toLowerCase());
                }else{
                    words[i] = $.trim(words[i].toLowerCase());
                }
            });
            var value = words.join("");
            this.value = value;
            $('.'+id).val(value);
        }else{
            this.value = '';
            $('.'+id).val('');
        }
    });
};