<?php

/**
 * Description of lliure
 *
 * @author Rodrigo
 */


define('contentType', 0);
define('defaultStyle', 1);
define('refresh', 2);

define('API', 'api');
define('APP', 'app');
define('OPT', 'opt');
define('NLI', 'nli');

define('DS', DIRECTORY_SEPARATOR);
define('WS', '/');


class autoLoad{
    
    static private

    /**
     * array com os caminhos que o auto load procura
     */
    $path = array(),

    /**
     * array com os functions que o auto load executa
     */
    $functions = array();
    
    public static function setPath($path){

        $basePath = realpath(__DIR__.WS.'..'.WS.'..'.WS.$path);
        $corte = strlen(realpath(__DIR__.WS.'..'.WS.'..')) - strlen($basePath) + 1;
        $path = $corte < 0? substr($basePath, $corte): NULL;
        
        if ($path !== NULL && !in_array($path, self::$path))
            self::$path[] = $path;
    }
    
    public static function setFunction($function){
        if (is_callable($function))
            self::$functions[] = $function;
    }

    public static function getFile($nome){
        
        $retorno = null;
        
        foreach (self::$functions as $function){
            $arquivo = realpath(__DIR__.WS.'..'.WS.'..'.WS.$function($nome, self::$path));
            if (is_file($arquivo)){
                $retorno = $arquivo;
                break;
            }
        }
        
        if ($retorno !== NULL)
            return $retorno;
        else
            throw new Exception('Erro do AutoLoad', 0);
    }

}


if (function_exists('spl_autoload_register')){
    spl_autoload_register(function ($nome){
        try {
            require_once autoLoad::getFile($nome);
        } catch (Exception $exc) {
            //echo $exc->getMessage();
            return NULL;
        }
    });
}else{
    function __autoload($nome){
        try {
            require_once autoLoad::getFile($nome);
        } catch (Exception $exc) {
            //echo $exc->getMessage();
            return NULL;
        }
    }
}



class lliure {
    
    private static 
    
    /**
     * sabe em qual lugar o lliure vai trabalhar. se é em app, opt, api ou nli.
     */
    $Modo,
    
    /**
     * Sabe o tema defout do sistema.
     */
    $defaultThemer = 'lliure',
            
    /**
     * garda o layout usado, por padrao lliure.
     */
    $layout = 'lliure',
            
    /**
     * garda se o layoute aparecera ou nao. padao sim.
     */
    $layoutStatus = true,
            
    /**
     * garda se o html vai aparecer ou nao. padrao sim.
     */
    $htmlSattus = true,
            
    /**
     * garda as metas dos layouts.
     */
    $Metas = array(),
            
    /**
     * garda os documentos do header da APP.
     */
    $DocsHeaderPRE = array(),
            
    /**
     * garda os documentos do header do LAYOUT.
     */
    $DocsHeaderPOS = array(),
            
    /**
     * garda em qual array de documentos sera gardado o documento.
     */
    $DocsHeader = null,
            
    /**
     * garda os ducumentos do footer
     */
    $DocsFooter = array(),

    /**
     * Garda o path da app;
     */       
    $pathApp,

    /**
     * Garda o arquivo header da app;
     */       
    $fileHeader,

    /**
     * Garda o arquivo start/body da app;
     */       
    $fileBody,

    /**
     * Carrega o llconf do lliure;
     */       
    $llconf;
    
    
    
    public static function start(){
        self::trataGet();
        self::bdconf();
        self::validaApp();
        self::logado();
        self::autoLoader();
        self::requires();
        self::setllconf();
        self::dadosApp();
        historico::iniciar();
        self::setVarDocsHeader();
        ProcessaApp();
    }

    private static function trataGet(){
        
        define('URLREAL', (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.substr($_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'], 0, -9));

        $arrUrl = explode("/", $_SERVER['REQUEST_URI']);
        $nReal = explode('/', URLREAL);

        for($i = 0; $i <= count($nReal)-4; $i++)
            unset($arrUrl[$i]);

        $gets = array_values($arrUrl);

        for ($i = 0; $i <= count($gets)-1; $i++) {	
            if(strpos($gets[$i], '=') != false){
                $va = explode('=', $gets[$i]);
                $_GET[$va[0]] = $va[1]; //monta os get
            } else {
                $_GET[$i] = $gets[$i]; //monta os get
            }
        }
        
        $_GET[0] = (isset($_GET[0]) && !empty($_GET[0])? $_GET[0]: 'index');
        
    }

    private static function bdconf(){
        if($_GET[0] !== 'instalar'){
            if (!file_exists('etc/bdconf.php')){
                header ('Location: ' . URLREAL . 'instalar');
            }else{
                require_once 'etc/bdconf.php';
            }
        }
    }

    private static function validaApp() {
        
        if(file_exists(APP.WS.$_GET[0]))
            self::$Modo = APP;
        elseif (file_exists(OPT.WS.$_GET[0]))
            self::$Modo = OPT;
        elseif (file_exists(API.WS.$_GET[0]))
            self::$Modo = API;
        elseif (file_exists(NLI.WS.$_GET[0]))
            self::$Modo = NLI;
        else
            header ('Location: ' . URLREAL);
        
        self::$pathApp = self::$Modo.WS.$_GET[0];
        self::$fileHeader = self::$pathApp.WS.'header.php';
        self::$fileBody = self::$pathApp.WS.'body.php';
        
    }

    public static function logado() {
        if (!isset($_SESSION['ll']['user']) && ($_GET[0] !== 'login') && self::$Modo != NLI){
            //$_SESSION['ll']['url'] = 
            header ('Location: ' . URLREAL . 'login');
        }
        return true;
    }

    private static function autoLoader() {
        autoLoad::setPath('api');
        autoLoad::setPath('lliure');
        autoLoad::setPath('tabelas');
        autoLoad::setFunction(function($class, $paths){
            $retorno = NULL;
            foreach ($paths as $value) {
                if (file_exists($value.WS.$class.WS.$class.'.php')){
                    $retorno = $value.WS.$class.WS.$class.'.php';
                    break;
                }
            }
            return $retorno;
        });
    }

    private static function requires() {
        require_once 'src'.WS.'php'.WS.'functions.php';
    }
    
    private static function setllconf() {
        
        if((self::$llconf = @simplexml_load_file('etc'.WS.'llconf.ll')) == false)
            self::$llconf = false;

    }
    
    private static function dadosApp() {
        
        if (($dados = @simplexml_load_file(self::$Modo.WS.$_GET[0].WS.'sys'.WS.'dados.ll')) !== FALSE)
            foreach ($dados as $key => $value)
                self::${$key} = $value;
        
    }
    
    private static function setVarDocsHeader(){
        self::$DocsHeader = &self::$DocsHeaderPRE;
    }



    /******** *        ***    **      **   *****  *     *  *******  ***********/
    /******** *       *   *     **  **    *     * *     *     *     ***********/
    /******** *      *     *      **      *     * *     *     *     ***********/
    /******** *      *******        **    *     * *     *     *     ***********/
    /******** *****  *     *          **   *****   *****      *     ***********/
    
    /**
     * configura o layout q o lliure ira usar.
     */
    public static function setLayout($layout){
        if (file_exists('layout' . WS . $layout))
            self::$layout = $layout;
    }

    /**
     * Aconfigura um arquivo diferente para ser mostrado no interior do layout
     * @param Sting $file
     */
    public static function setFileBody($file){
        self::$fileBody = $file;
    }
    
    /**
     * Apelido para função setFileBody.
     */
    public static function setFileStart($file){
        self::setFileBody($file);
    }
    
    /**
     * Devolve o caminho da app
     */
    public static function getPathApp(){
        return self::$pathApp;
    }

    /**
     * Adiciona um documento a lista de documentos do head
     * @param Sting $documento
     */
    static function addDocHead($documento){
        self::addDoc(self::$DocsHeader, $documento);
    }
    
    /**
     * Adiciona um documento a lista de documentos do footer
     * @param Sting $documento
     */
    static function addDocFooter($documento){
        self::addDoc(self::$DocsFooter, $documento);
    }
    
    private static function addDoc(array &$array, $documento){
        if (!in_array($documento, $array))
            $array[] = $documento;
    }

     /**
     * require todos os documentos da lista no head
     */
    private static function getDocsHead(){
        self::getDocs(self::$DocsHeaderPOS);
        self::getDocs(self::$DocsHeaderPRE);
    }
    
    /**
     * require todos os documentos da lista no footer
     */
    private static function getDocsFooter(){
        self::getDocs(self::$DocsFooter);
    }

    private static function getDocs(array &$docs) {
        if (!empty($docs)) {
            foreach ($docs as $valor) {
                if (strpos($valor, ':') !== FALSE){
                    $e = explode(":", $valor, 2);
                    $ext = array_shift($e);
                    $valor = array_shift($e);
                }else{
                    $e = explode(".", $valor);
                    $ext = strtolower(end($e));
                }
                switch ($ext){
                    case 'css':
                        echo '<link type="text/css" rel="stylesheet" href="' . $valor . '" />';
                    break;
                    case 'js':
                        echo '<script type="text/javascript" src="' . $valor . '"></script>';
                    break;
                    case 'ico':
                        echo '<link type="image/x-icon" rel="SHORTCUT ICON" href="' . $valor . '" />';
                    break;
                    case 'html':
                    case 'php':
                        require $valor;
                    break;
                }
            }
        }
    }
    
    public static function base($href){
        self::$Metas[] = array('base' => array('href' => $href));
    }
    
    public static function metas($name, $content){
        $httpEquiv = array('content-type', 'default-style', 'refresh');
        
        if (is_numeric($name))
            self::$Metas[] = array('meta' => array('http-equiv' => $httpEquiv[$name], 'content' => $content));
        else
            self::$Metas[] = array('meta' => array('name' => $name, 'content' => $content));
    }
    
    private static function getMetas(){
        
        foreach (self::$Metas as $key => $value) {
            echo '<';
            foreach ($value as $key => $value) {
                echo $key . ' ';
                foreach ($value as $key => $value) {
                    echo $key . '="' . $value . '" ';
                }
            }
            echo '/>';
        }
        
    }

    public static function header(){
        echo 
        '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">',
        '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br">',
            '<head>',
                '<title>lliure Web Application Platform</title>',
                self::getMetas(), self::getDocsHead(),
            '</head>', '<body>';
    }

    public static function footer(){
        echo self::getDocsFooter(), '</body>', '</html>';
    }

    public static function headerLayoutOff(){
        header ('Content-type: text/html; charset=ISO-8859-1');
        echo self::getDocsHead();
    }

    public static function footerLayoutOff(){
        echo self::getDocsFooter();
    }
    
    public static function getPathLayout(){
        return 'layout/' . self::$layout;
    }
    
    public static function setLayoutOff(){
        self::$layoutStatus = FALSE;
    }
    
    public static function setHtmlOff(){
        self::$htmlSattus = FALSE;
    }




    /*********** ***** *   * *   *  **** ***** *  ***  *   * ***** **********/
    /*********** *     *   * **  * *       *     *   * **  * *     **********/
    /*********** ***** *   * * * * *       *   * *   * * * * ***** **********/
    /*********** *     *   * *  ** *       *   * *   * *  **     * **********/
    /*********** *      ***  *   *  ****   *   *  ***  *   * ***** **********/
    
    /**
     * Funcao de inspecionar variaveis.
     * 
     * considere a var:<br/>
     * $var = array('teste', 'teste 2');
     * 
     * pase a variavel a ser mostrada:<br/>
     * lliure::pre($var);<br/>
     * e seu conteuro aparece.<br/>
     * <code>array(<br/>
     * &nbsp;&nbsp;&nbsp;&nbsp;[0] => teste,<br/>
     * &nbsp;&nbsp;&nbsp;&nbsp;[1] => teste 2<br/>
     * )</code>
     * 
     * ou pace a var e um prefixo para melhor compreençao do resultado:<br/>
     * lliure::('$var', $var);
     * 
     * <code>$var = array(<br/>
     * &nbsp;&nbsp;&nbsp;&nbsp;[0] => teste,<br/>
     * &nbsp;&nbsp;&nbsp;&nbsp;[1] => teste 2<br/>
     * )</code>
     * 
     * <i>lliure::pre()</i> consegue mostrar os valores de <b>NULL</b>, <b>boolean</b>, <b>string</b>, <b>array</b> e <b>object</b>
     * 
     */
    public static function pre() {
        
        //seta as variavies
        $mostrar = NULL;
        switch (func_num_args()){
            case 2:
                $texto = (is_string(func_get_arg(0))? func_get_arg(0) . ' = ': '');
                $quetao = func_get_arg(1);
            break;
            case 1:
                $texto = '';
                $quetao = func_get_arg(0);
            break;
        }
        
        //procesa a alternativa
        if (func_num_args() >= 1 && func_num_args() <= 2){
            if(is_null($quetao))
                $mostrar = $texto . 'NULL';
            elseif(is_bool($quetao))
                $mostrar = $texto . ($quetao? 'TRUE': 'FALSE');
            elseif(is_string($quetao))
                $mostrar = $texto . $quetao;
            elseif(is_array($quetao) || is_object($quetao))
                $mostrar = $texto . print_r($quetao, true);
        }
        
        //mostra o resultado se tiver
        if ($mostrar !== NULL)
            echo '<pre>', $mostrar, '</pre>';
    }
    
    public static function url(array $url){
        
        $retorno = array();
        foreach ($url as $key => $value)
            if(is_string ($key))
                $retorno[] = $key.'='.$value;
            else
                $retorno[] = $value;
            
        return implode('/', $retorno);
        
    }
    
    public static function llconf(){
        return self::$llconf;
    }

    public static function appHeder(){
        return self::$fileHeader;
    }

    public static function appBody(){
        return self::$fileBody;
    }
    
    public static function getHtmlSattus(){
        return self::$htmlSattus;
    }
    
    public static function getLayoutStatus(){
        return self::$layoutStatus;
    }

    public static function getModo() {
        return self::$Modo;
    }

    public static function setStartLayout() {
        self::$DocsHeader = &self::$DocsHeaderPOS;
    }
    
}



function ProcessaApp(){

    lliure::base(URLREAL);
    lliure::metas('url', URLREAL);
    lliure::metas(contentType, 'text/html; charset=iso-8859-1');
    lliure::metas('author', 'Jeison Frasson');
    lliure::metas('DC.creator', 'Jeison Frasson');
    lliure::metas('DC.creator.address', 'jomadee@lliure.com.br');
    lliure::metas('collaboration', 'Rodrigo Dechen');
    lliure::metas('collaboration.address', 'mestri.rodrigo@gmail.com');
    
    if (file_exists(lliure::appHeder()))
        require_once lliure::appHeder();
    
    lliure::setStartLayout();

    if(lliure::getHtmlSattus()){

        if(lliure::getLayoutStatus() && file_exists(lliure::getPathLayout() . WS . 'header.php'))
            require_once lliure::getPathLayout() . WS . 'header.php';
        else
            lliure::headerLayoutOff();

        if (file_exists(lliure::appBody()))
            require_once lliure::appBody();

        if(lliure::getLayoutStatus() && file_exists(lliure::getPathLayout() . WS . 'footer.php'))
            require_once lliure::getPathLayout(). WS . 'footer.php';
        else
            lliure::footerLayoutOff();

    }

}