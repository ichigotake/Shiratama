<?php

function __autoload($_classname) {
    $classname = trim($_classname);
    if (empty($classname)) {
        return false;
    }

    $path = str_replace('_', '/', $classname) . '.php';
    require_once($path);
}

class Shiratama_AutoLoader
{
}

