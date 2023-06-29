<?php

namespace home;
use home\Home;
require_once("./template/component/home/home.php");

class Today extends Home {

    public function __construct() {
        parent::__construct("today");
        $this->build();
    }

    public function build() {
        $today = strftime("%Y-%m-%d");
        $this->replaceValue("Data", strftime("%d ") . strtoupper(substr(strftime("%B"), 0, 3)));
        $this->_connection->connect();
        $result = $this->_connection->query("SELECT DISTINCT `movie_title` FROM `screenings` WHERE `start_date` = '$today'");
        $rows = mysqli_num_rows($result);
        if ($rows >= 1) {
            while($movie = $result->fetch_row()) {
                $this->replaceTag("ITEM", new Home("todayItem"));
                $this->replaceValue("Title", $movie[0]);
                $this->replaceValue("Link", "movie.php?title=" . urlencode($movie[0]));
                $times = $this->_connection->query("SELECT `start_time` FROM `screenings` WHERE `start_date` = '$today' AND `movie_title` = \"". $movie[0] ."\" ORDER BY `start_time` ASC");
                while($start_time = $times->fetch_row()) {
                    $aria = "Prenota " . $movie[0] . " per oggi alle ore " . strftime("%H:%M", strtotime($start_time[0]));
                    $this->replaceTag("TIME", "<li><a aria-label=\"" . $aria . "\" href=\"book.php?title=<valTitle/>&date=<valDate/>&time=<valTime/>\"><time>" . strftime("%H:%M", strtotime($start_time[0])) . "</time></a></li>\n<TIME/>");
                    $this->replaceValue("Title", urlencode($movie[0]));
                    $this->replaceValue("Date", $today);
                    $this->replaceValue("Time", $start_time[0]);
                }
                $this->replaceTag("TIME", "");
            }
            $this->replaceTag("ITEM", "");
        } else
            $this->replaceTag("ITEM", "<li><p id=\"no-screenings\">Nessuna proiezione</p></li>");

        $promo = $this->_connection->query("SELECT `promo` FROM `promo` WHERE `day` = \"" . strftime("%u")-1 . "\"")->fetch_row();
        $this->replaceValue("Promo", $promo[0]);
        $this->_connection->disconnect();
    }
}

?>