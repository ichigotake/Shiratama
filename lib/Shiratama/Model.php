<?php

class Shiratama_Model
{

    public $name = null;

    public $tableName = null;

    public $primaryKey = 'id';

    public $sqlMaker;

    public function __construct($params)
    {
        $this->dbh = $params['dbh'];

        if (is_null($this->name)) {
            $this->name = preg_replace("/_?Model_?/", "", get_class($this));
        }

        if (is_null($this->tableName)) {
            $this->tableName = Shiratama_Util::snakeCase($this->name);
        }

        $this->sqlMaker = new SQL_Maker(array('driver' => 'mysql'));
    }

    public function query($sql = null, $binds = array())
    {
        if (!$sql) {
            return false;
        }
        try {
            if ($binds) {
                $sth = $this->dbh->prepare($sql);
                $res = $sth->execute($binds);
            } else {
                $res = $this->dbh->query($sql);
            }
            return $res;
        } catch (PDOException $e) {
            print_r($e->getMessage());
            return false;
        }
    }

    public function getInfo($table = null, $where = array(), $opt = array())
    {
        $tableName = (is_null($table)) ? $this->tableName : $table;
        list($sql, $binds) = $this->sqlMaker->select($tableName, array('*'), $where, $opt);
        $res = $this->query($sql, $binds);

        return (isset($res[0])) ? $res[0] : $res;
    }

    public function getList($table = null, $where = array(), $opt = array())
    {
        $tableName = (is_null($table)) ? $this->tableName : $table;
        list($sql, $binds) = $this->sqlMaker->select($tableName, array('*'), $where, $opt);
        return $this->query($sql, $binds);
    }

    public function insert($table = null, $values = array())
    {
        $tableName = (is_null($table)) ? $this->tableName : $table;
        list($sql, $binds) = $this->sqlMaker->insert($tableName, $values);
        return $this->query($sql, $binds);
    }

    public function update($table = null, $set = array(), $where = array())
    {
        $tableName = (is_null($table)) ? $this->tableName : $table;
        list($sql, $binds) = $this->sqlMaker->update($tableName, $set, $where);
        return $this->query($sql, $binds);
    }

    public function delete($table = null, $where = array())
    {
        $tableName = (is_null($table)) ? $this->tableName : $table;
        list($sql, $binds) = $this->sqlMaker->delete($tableName, $where);
        return $this->query($sql, $binds);
    }

}
