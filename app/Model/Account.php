<?php

class Model_Account extends Shiratama_Model
{
    function getInfo($id)
    {
        $sth = $this->dbh->prepare('select * from account where id = ?');
        $sth->execute(array($id));
        return $sth->fetch(PDO::FETCH_ASSOC);
    }
}

