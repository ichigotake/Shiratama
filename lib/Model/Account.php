<?php

class Model_Account extends Shiratama_Model
{
    function insert($values)
    {
        return parent::insert($this->tableName, $values);
    }

}

