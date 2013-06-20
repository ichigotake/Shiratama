<?php

require 'Shiratama/Constant.php';

class Shiratama {

    public static $VERSION = '0.7';

    var $env;

    var $config;

    var $db;

    public function __get($name)
    {
        if (method_exists($this, $name)) {
            return $this->$name();
        }

        if (isset($this->$name)) {
            return $this->$name;
        }

        if (!isset($this->$name) && file_exists(Shiratama_Util::catfile(APP_ROOT, 'Model', "$name.php"))) {
            $this->$name = Shiratama_Util::loadComponent('Model', $name, array('dbh' => $this->db->dbh));
            return $this->$name;
        }
    }

    public function __construct($config)
    {
        $this->env = $_SERVER;

        $this->config = $config;
        $this->db = new Shiratama_DB($this->config['DB']);
    }

    public function getInstance()
    {
        $c =& new Shiratama();
        return $c;
    }

}
