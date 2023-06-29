<?php
namespace component;
use template\Template;

class Component extends Template {
    
    protected $_connection;

    public function __construct(string $name) {
        $this->_connection = $_SESSION["connection"];
        parent::__construct($name);
    }

    public function load(): void {
        $filename = './template/component/html/' . $this->_name . '.template.html';
        if(file_exists($filename))
            $this->_template = file_get_contents($filename);
        else
            $this->_template = ' --> Error: this directory is not a file.';
    }

    public function isAdmin(string $username) {
        $this->_connection->connect();
        $result = $this->_connection->query("SELECT * FROM admin WHERE username = '".$username."'");
        $isAdmin = false;
        if(mysqli_num_rows($result) == 1) {
            $isAdmin = true;
        }
        $this->_connection->disconnect();
        return $isAdmin;
    }
}
?>