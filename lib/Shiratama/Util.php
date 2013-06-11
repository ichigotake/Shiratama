<?php

class Shiratama_Util 
{
    public function isController($controller)
    {
        return file_exists(self::catfile(APP_ROOT, 'Controller', "$controller.php"));
    }

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

    public function load_component($base, $name, $params)
    {
        $classname = "{$base}_{$name}";
        return new $classname($params);
    }

    public function camelize($string)
    {
        if (!$string) {
            return $string;
        }

        $str = strstr($string, '_', ' ');
        $str = ucwords($str);

        return str_replace(' ', '', $str);
    }
}
