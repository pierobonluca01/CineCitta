<?php
namespace movie;
use movie\Movie;
require_once("./template/component/movie/movie.php");

class MovieInfo extends Movie {
    
    public function __construct() {
        parent::__construct("movieInfo");
        $this->build();
    }

    public function build() {
        if(isset($_GET["title"])) {
            $this->_connection->connect();
            $movie = $this->_connection->query("SELECT * FROM `movies` WHERE `title` = \"" . addslashes($_GET["title"]) . "\"")->fetch_row();
            $this->replaceValue("Title", $movie[0]);
            $this->replaceValue("Image", $movie[5]);
            $date = date("d/m/Y", strtotime($movie[2]));
            $this->replaceValue("ReleaseDate", $movie[2]);
            $this->replaceValue("ReleaseDateFormatted", $date);
            $this->replaceValue("Duration", $movie[3]!=0 ? $movie[3] : "<abbr title=\"To Be Defined\" lang=\"en\">TBD</abbr>");
            $this->replaceValue("Countries", $movie[4]);
            $this->replaceValue("Synopsis", $movie[1]);
            $this->_connection->disconnect();
        }
        
    }

}
?>