<?php

class Shiratama_DB extends Shiratama_Model
{
    public function __construct($config)
    {
        $this->dbh = new PDO($config[0], $config[1], $config[2]);
        $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        parent::__construct(array('driver' => 'mysql', 'dbh' => $this->dbh));
    }

}
