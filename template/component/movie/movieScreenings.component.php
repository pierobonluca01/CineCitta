<?php
namespace movie;
use movie\Movie;
require_once("./template/component/movie/movie.php");

class MovieScreenings extends Movie {
    
    public function __construct() {
        parent::__construct("movieScreenings");
        $this->build();
    }

    public function build() {
        if(isset($_GET["title"])) {
            $this->_connection->connect();
            $today = strftime("%Y-%m-%d");
            $movies = $this->_connection->query("SELECT DISTINCT `movie_title`, `start_date` FROM `screenings` WHERE `movie_title` = \"" . addslashes($_GET["title"]) . "\" AND `start_date` >= '" . $today . "' ORDER BY `start_date` ASC");
            if(mysqli_num_rows($movies) > 0) {
                while($movie = $movies->fetch_row()) {
                    $this->replaceTag("SCREENINGS", new Movie("screeningContainer"));
                    $date = $movie[1];
                    $this->replaceValue("Date", $date);
                    $this->replaceValue("FormattedDate", ucfirst(strftime("%A ", strtotime($date))) . strftime("%d/%m/%Y", strtotime($date)));
                    
                    $result = $this->_connection->query("SELECT `start_time` FROM `screenings` WHERE `start_date` = '" . $date . "' AND `movie_title` = \"". addslashes($_GET["title"]) ."\" ORDER BY `start_time` ASC");
                    while($start_time = $result->fetch_row()) {
                        $aria = "Prenota " . $_GET["title"] . " per il giorno " . strftime("%d %B %Y", strtotime($date)) . " alle ore " . strftime("%H:%M", strtotime($start_time[0]));
                        $this->replaceTag("TIME", "<li><a aria-label=\"" . $aria . "\" href=\"book.php?title=<valTitle/>&date=<valDate/>&time=<valTime/>\"><time>" . strftime("%H:%M", strtotime($start_time[0])) . "</time></a></li>\n<TIME/>");
                        $this->replaceValue("Title", urlencode($_GET["title"]));
                        $this->replaceValue("Date", $date);
                        $this->replaceValue("Time", $start_time[0]);
                    }
                    $this->replaceTag("TIME", "");
                }
                $this->replaceTag("SCREENINGS", "");
            } else  {
                $this->replaceTag("SCREENINGS", "<p id=\"no-screenings\">Nessuna proiezione</p>");
            }
            $this->_connection->disconnect();
        }
        

    }

}