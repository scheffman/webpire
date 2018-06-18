<?php

class dataBase {
    private $conn;

    function __construct() {
        try {
            $db = 'sqlite:webpire.db';
            $this->conn = new PDO($db) or die('Cannot open the database');
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo 'Connected';
        } catch(PDOExeption $e) {
            echo 'Not connected' . $e->getMessage();
        }
    }

    function createTable($table, $cols) {
        $query = 'CREATE TABLE IF NOT EXISTS ' .$table. ' (';
        foreach ($cols as $key => $value) {
            $query = $query .$key .' ' .$value .', ';
        }
        $query = rtrim($query, ', ');
        $query = $query .')';
        # debugg, remove later
        echo $query;
        $this->conn->exec($query);
    }

    function insert($table, $cols) {
        $keys = '';
        $values = '';
        $query = 'INSERT INTO ' .$table. ' (';
        foreach ($cols as $key => $value) {
            $keys = $keys .$key. ', ';
            $values = $values .$value. ', ';
        }
        $keys = rtrim($keys, ', ');
        $values = rtrim($values, ', ');
        $query = $query .$keys. ') VALUES (' .$values. ')';
        echo $query;
        $this->conn->exec($query);
    }

    function lastInsert() {
        $last_id = $this->conn->lastInsertId();
        echo $last_id;
    }

    function disconnect() {
        $conn = null;
        echo 'Disconnected';
    }
}

?>
