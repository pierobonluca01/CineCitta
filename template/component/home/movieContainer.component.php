<?php

namespace home;
use home\Home;
require_once("./template/component/home/home.php");

class MovieContainer extends Home {

    private $_entry;
    private $_id;

    public function __construct(array $entry, int $id) {
        $this->_entry = $entry;
        $this->_id = $id;
        parent::__construct("movieContainer");
        $this->build();
    }

    public function build() {
        $this->replaceValue("Id", "movie" . $this->_id);
        $this->replaceValue("Link", "movie.php?title=" . urlencode($this->_entry[0]));
        $this->replaceValue("Title", $this->_entry[0]);
        $this->replaceValue("Synopsis", $this->_entry[1]);
        $date = date("d/m/y", strtotime($this->_entry[2]));
        $this->replaceValue("ReleaseDate", $this->_entry[2]);
        $this->replaceValue("ReleaseDateFormatted", $date);
        $this->replaceValue("Duration", $this->_entry[3]!=0 ? $this->_entry[3] : "<abbr title=\"To Be Defined\" lang=\"en\">TBD</abbr>");
        $this->replaceValue("Countries", $this->_entry[4]);
    }
}

?>