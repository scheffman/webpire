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
        $query = 'CREATE TABLE ' .$table. ' (';
        foreach ($cols as $key => $value) {
            $query .= $key .' ' .$value .', ';
        }
        $query = rtrim($query, ', ');
        $query .= ')';
        # debugg, remove later
        echo $query;
        $this->conn->exec($query);
    }

    function insert($table, $cols) {
        $keys = '';
        $values = '';
        $query = 'INSERT INTO ' .$table. ' (';
        foreach ($cols as $key => $value) {
            $keys .= $key. ', ';
            $values .= '\'' .$value. '\', ';
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

    function select($table, $cols) {
        $query = 'SELECT ';
        foreach ($cols as $col) {
            $query .= $col. ', ';
        }
        $query = rtrim($query, ', ');
        $query .= ' FROM ' .$table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    function disconnect() {
        $conn = null;
        echo 'Disconnected';
    }
}

?>
