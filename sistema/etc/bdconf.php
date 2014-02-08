<?php

define('BD_TYPE',       'mysql');
define('BD_HOSTNAME',   'localhost');
define('BD_USERNAME',   'root');
define('BD_PASSWORD',   '');
define('BD_TABLENAME',  'lliure_5');
define('PREFIXO',       'll_');
define('SISTEMA',       'sistema');
define('DS',            DIRECTORY_SEPARATOR);

session_name(BD_TABLENAME);
session_start();

require_once realpath(__DIR__.DS.'..'.DS.'lliure'.DS.'db'.DS.'db.php');

db::conectarPDO() or die("Site em manutenчуo");
?>