<?php

$include_paths = array(
    __DIR__ . '/app',
    __DIR__ . '/lib',
);
set_include_path(get_include_path() . PATH_SEPARATOR . join(PATH_SEPARATOR, $include_paths));

function __autoload($_classname) {
    $classname = trim($_classname);
    if (empty($classname)) {
        return false;
    }

    $path = str_replace('_', '/', $classname) . '.php';
    require_once($path);
}

$config = Shiratama_Config::load(Shiratama_Util::catfile('config', 'development.php'));

$app = new Shiratama_Web($config);
$app->toApp();


