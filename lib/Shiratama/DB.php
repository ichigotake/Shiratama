<?php

class Shiratama_DB
{
    public function __construct($config)
    {
        $this->dbh = new PDO($config[0], $config[1], $config[2]);
        $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

}
