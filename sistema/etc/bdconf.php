<?php

define('BD_TYPE',       'mysql');
define('BD_HOSTNAME',   'localhost');
define('BD_USERNAME',   'root');
define('BD_PASSWORD',   '');
define('BD_TABLENAME',  'lliure_5');
define('PREFIXO',       'll_');
define('SISTEMA',       'sistema');

session_name(BD_TABLENAME);
session_start();

require_once realpath(__DIR__.'/../lliure/db/db.php');

db::conectarPDO() or die("Site em manutenчуo");
?>