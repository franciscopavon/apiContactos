<?php
/**
 * Database
 * 
 * @method connect() Connect to the database
 * @method disconnect() Disconnect from the database
 * @method isConnected() Check if the database is connected
 * @method get($table, $rows) Get all the rows from a table
 * @method getWhere($table, $rows, $where) Get all the rows from a table where row = value
 * @method getMatch($table, $rows, $where, $match) Get all the rows from a table that match a condition
 * @method insert($table, $rows, $values) Insert a new row into a table
 * @method update($table, $rows, $where) Update a row in a table
 * @method delete($table, $where) Delete a row from a table
 */
class Database{
    protected $db;
    protected $isConnected = false;

    public function connect(){
        try{
            $this->db = new PDO("mysql:host=localhost;dbname=bd_contactos", 'root', '');
            $this->db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
            $this->db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
            $this->isConnected = true;
            return true;
        }catch(PDOException $e){
            $this->isConnected = false;
            return false;
        }
    }

    public function disconnect(){
        $this->isConnected = false;
        $this->db = null;
    }

    public function isConnected(){
        return $this->isConnected;
    }

    public function get($table, $rows){
        $sql = "SELECT $rows FROM $table";
        $queryResult = $this->db->query($sql);
        $result = array();
        foreach($queryResult as $value){
            array_push($result, $value);
        }
        return $result;
    }

    public function insert($table, $rows, $values){
        $sql = "INSERT INTO $table ($rows) VALUES ($values)";
        $queryResult = $this->db->query($sql);
        return $queryResult;
    }

    public function update($table, $rows, $where){
        $sql = "UPDATE $table SET $rows WHERE $where";
        $queryResult = $this->db->query($sql);
        return $queryResult;
    }

    public function delete($table, $where){
        $sql = "DELETE FROM $table WHERE $where";
        $queryResult = $this->db->query($sql);
        return $queryResult;
    }

    public function getWhere($table, $rows, $where){
        $sql = "SELECT $rows FROM $table WHERE $where";
        $queryResult = $this->db->query($sql);
        $result = array();
        foreach($queryResult as $value){
            array_push($result, $value);
        }
        return $result;
    }

    public function getMatch($table, $rows, $where, $match){
        $sql = "SELECT $rows FROM $table WHERE $where LIKE '%$match%'";
        $queryResult = $this->db->query($sql);
        $result = array();
        foreach($queryResult as $value){
            array_push($result, $value);
        }
        return $result;
    }

}