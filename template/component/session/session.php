<?php

namespace session;
use component\Component;
use mysqli;
require_once("./template/component/component.php");

class Session extends Component {

    protected $_connection;
    
    public function __construct($name) {
        $this->_connection = $_SESSION["connection"];
        parent::__construct($name);
    }

    public function load(): void {
        $filename = './template/component/session/html/' . $this->_name . '.template.html';
        if(file_exists($filename))
            $this->_template = file_get_contents($filename);
        else
            $this->_template = ' --> Error: this directory is not a file.';
    }
}
?>