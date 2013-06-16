<?php

define('APP_VERSION', '0.1');

$include_paths = array(
    __DIR__ . '/app',
    __DIR__ . '/lib',
);
set_include_path(get_include_path() . PATH_SEPARATOR . join(PATH_SEPARATOR, $include_paths));

require 'Shiratama/AutoLoader.php';


$config = Shiratama_Util::loadConfig(Shiratama_Util::catfile('config', 'development.php'));

$app = new Shiratama_Web($config);
$app->toApp();


