<?php 

switch (!empty($_GET[1])? $_GET[1]: NULL){

    case 'etapa-1':
        
        if(!empty($_POST)){
            
            $r = array('status' => 'OK', 'code' => 0, 'msg' => 'OK', 'dados' => $_POST);
            
            try {
                $DB = @new PDO('mysql:host='. $_POST['bd-host']. ';dbname='. $_POST['bd-banc'], $_POST['bd-user'], $_POST['bd-pass']);
            } catch (PDOException $exc) {
                $r['status'] = 'error';
                $r['msg'] = $exc->getMessage();
                $r['code'] = $exc->getCode();
            }
            
            if($r['code'] == 0 && !file_exists('etc/bdconf.php')){
                $bdconf = fopen('etc/bdconf.php', 'w');
                fwrite($bdconf, "<?php\n");
                fwrite($bdconf, "\n");
                fwrite($bdconf, "define('BD_TYPE',       'mysql');\n");
                fwrite($bdconf, "define('BD_HOSTNAME',   '". $_POST['bd-host']. "');\n");
                fwrite($bdconf, "define('BD_USERNAME',   '". $_POST['bd-user']. "');\n");
                fwrite($bdconf, "define('BD_PASSWORD',   '". $_POST['bd-pass']. "');\n");
                fwrite($bdconf, "define('BD_TABLENAME',  '". $_POST['bd-banc']. "');\n");
                fwrite($bdconf, "define('PREFIXO',       '". $_POST['bd-pfix']. "');\n");
                fwrite($bdconf, "define('SISTEMA',       'sistema');\n");
                fwrite($bdconf, "\n");
                fwrite($bdconf, "session_name(BD_TABLENAME);\n");
                fwrite($bdconf, "session_start();\n");
                fwrite($bdconf, "\n");
                fwrite($bdconf, "require_once realpath(dirname(__FILE__).'/../lliure/db/db.php');\n");
                fwrite($bdconf, "\n");
                fwrite($bdconf, "db::conectarPDO() or die('Site em manutenção');");
                fclose($bdconf);
            }
            
            echo json_encode($r);
            lliure::setHtmlOff();
            
        }else{
        
            lliure::addDocHead('src/js/jquery.validate.js');
            lliure::addDocFooter(lliure::getPathApp(). WS. 'js'. WS. 'etapa1.js');

            $form = new formx('form');
            $form
                ->action('instalar')
                ->dados(array(
                    'bd-host' => 'localhost',
                    'bd-user' => 'root',
                    'bd-pfix' => 'll_'
                ))
                ->fieldset()
                    ->texto(
                         '<h1>Etapa 1: Banco de Dados</h1>'
                        .'<p>Banco de dados.</p>'
                    )
                    ->input('bd-host', 'Host')
                    ->input('bd-user', 'Usuario')
                    ->input('bd-pass', 'Senha', 'password')
                    ->input('bd-banc', 'Banco de dados')
                    ->input('bd-pfix', 'Prefixo')
                    ->linha(2, linha::float_right)
                        ->button('Criar', button::ACTION)
                        ->aButton('Etapa 2', 'instalar/etapa-2');
            
        }
        
    break; 

    default:
        
        $form = new formx('form');
        $form
            ->action('instalar')
            ->fieldset()
                ->texto(
                     '<h1>Ola!</h1>'
                    .'<p>Bem vindo.</p>'
                )
                ->linha(2, linha::float_right)
                    ->aButton('Etapa 1', 'instalar/etapa-1');

    break;
    
}