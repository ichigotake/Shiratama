<?php

class Shiratama_Util 
{

    public function catfile()
    {
        $paths = array();
        foreach (func_get_args() as $f) {
            if (is_array($f)) {
                $paths = array_merge($paths, $f);
            } else {
                $paths[] = $f;
            }
        }

        return join(DIRECTORY_SEPARATOR, $paths);
    }

    public function loadConfig($file)
    {
        include $file;
        return $config;
    }

    public function loadComponent($base, $name, $params)
    {
        $classname = "{$base}_{$name}";
        return new $classname($params);
    }

    {
}
