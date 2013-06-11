<?php

class Shiratama_Config
{

    public function load($file)
    {
        include $file;
        return $config;
    }
}
