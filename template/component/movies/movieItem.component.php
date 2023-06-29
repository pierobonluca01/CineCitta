<?php
namespace movies;
use movies\Movies;
require_once("./template/component/movies/movies.php");

class MovieItem extends Movies {
    
    private $_entry;

    public function __construct(array $entry) {
        $this->_entry = $entry;
        parent::__construct("movieItem");
        $this->build();
    }

    public function build() {
        $this->replaceValue("Link", "movie.php?from=movies&title=" . urlencode($this->_entry[0]));
        $this->replaceValue("Image", $this->_entry[5]);
        $this->replaceValue("Title", $this->_entry[0]);
        $date = date("d/m/y", strtotime($this->_entry[2]));
        $this->replaceValue("ReleaseDate", $this->_entry[2]);
        $this->replaceValue("ReleaseDateFormatted", $date);
        $this->replaceValue("Duration", $this->_entry[3]!=0 ? $this->_entry[3] : "<abbr title=\"To Be Defined\" lang=\"en\">TBD</abbr>");
        $this->replaceValue("Countries", $this->_entry[4]);
    }

}
?>