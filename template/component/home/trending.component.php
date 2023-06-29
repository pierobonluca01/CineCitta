<?php

namespace home;
use home\MovieContainer;
use mysqli;
require_once("./template/component/home/home.php");
require_once("./template/component/home/movieContainer.component.php");

class Trending extends Home {

    protected $_connection;

    public function __construct(){
        $this->_connection = $_SESSION["connection"];
        parent::__construct("trending");
        $this->build();
    }

    public function build() {
        $this->_connection->connect();
        $result = $this->_connection->query("SELECT * FROM movies ORDER BY RAND() LIMIT 3");
        $id = 1;
        while($entry = $result->fetch_row()) {
            $this->replaceTag("MOVIECONTAINER" . $id, new MovieContainer($entry, $id));
            $this->replaceValue("MoviePoster" . $id, $entry[5]);
            $id+=1;
        }
        $result->free_result();
        $this->_connection->disconnect();        
    }
}

?>