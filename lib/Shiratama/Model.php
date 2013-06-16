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
        if ($binds) {
            $sth = $this->dbh->prepare($sql);
            $res = $sth->execute($binds);
        } else {
            $res = $this->dbh->query($sql);
        }
        return $res;

    }

}
