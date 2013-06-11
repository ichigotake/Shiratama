<?php

class Shiratama_Model
{
    public function __construct($params)
    {
        $this->dbh = $params['dbh'];
    }

    public function query($sql = null, $bind = array())
    {
        if (!$sql) {
            return false;
        }

        return $this->dbh->query($sql, $bind);
    }

}
