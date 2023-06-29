<?php

namespace model;

use mysqli;
use mysqli_result;

class Database {
    
    private $_hostname;
    private $_username;
    private $_password;
    private $_dbname;

    private $_connection;

    public function __construct(string $hostname, string $username, string $password, string $dbname) {
        $this->_hostname = $hostname;
        $this->_username = $username;
        $this->_password = $password;
        $this->_dbname = $dbname;
    }

    public function connect() {
        $this->_connection = mysqli_connect($this->_hostname, $this->_username, $this->_password, $this->_dbname);
        mysqli_set_charset($this->_connection, "utf8mb4");
        if(mysqli_connect_errno()) {
            echo "Connessione fallita (" . mysqli_connect_errno() . "): " . mysqli_connect_error();
            exit();
        } 
    }

    public function disconnect() {
        mysqli_close($this->_connection);
    }

    public function query(string $query): mysqli_result|bool {
        $result = mysqli_query($this->_connection, $query) or die(mysql_error());
        return $result;
    }

    public function real_escape_string(string $string): string {
        return mysqli_real_escape_string($this->_connection, $string);
    }
}

?>