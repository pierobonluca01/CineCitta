<?php
namespace screenings;
require_once("./template/component/screenings/screenings.php");

class ScheduleContainer extends Screenings {

    private $_title;
    private $_date;
    
    public function __construct(string $movie_title, string $start_date) {
        parent::__construct("scheduleContainer");
        $this->_title = $movie_title;
        $this->_date = $start_date;
        $this->build();
    }

    public function build() {
        $this->_connection->connect();
        $movie = $this->_connection->query("SELECT * FROM `movies` WHERE `title` = \"" . $this->_title . "\"");
        $movie = $movie->fetch_row();
        $this->replaceValue("TitleFormatted", $this->_title);
        $this->replaceValue("Link", "movie.php?from=screenings&title=" . urlencode($this->_title));
        $this->replaceValue("ReleaseDate", $movie[2]);
        $this->replaceValue("ReleaseDateFormatted", date("d/m/y", strtotime($movie[2])));
        $this->replaceValue("Duration", $movie[3]!=0 ? $movie[3] : "<abbr title=\"To Be Defined\" lang=\"en\">TBD</abbr>");
        $this->replaceValue("Countries", $movie[4]);
        $this->replaceValue("Image", $movie[5]);
        
        $result = $this->_connection->query("SELECT `start_time` FROM `screenings` WHERE `start_date` = '" . $this->_date . "' AND `movie_title` = \"". $this->_title ."\" ORDER BY `start_time` ASC");
        $this->_connection->disconnect();
        while($start_time = $result->fetch_row()) {
            $aria = "Prenota " . $this->_title . " per il giorno " . strftime("%d %B %Y", strtotime($this->_date)) . " alle ore " . strftime("%H:%M", strtotime($start_time[0]));
            $this->replaceTag("TIME", "<li><a aria-label=\"" . $aria . "\" href=\"book.php?title=<valTitle/>&date=<valDate/>&time=<valTime/>\"><time>" . strftime("%H:%M", strtotime($start_time[0])) . "</time></a></li>\n<TIME/>");
            $this->replaceValue("Title", urlencode($this->_title));
            $this->replaceValue("Date", $this->_date);
            $this->replaceValue("Time", $start_time[0]);
        }
        $this->replaceTag("TIME", "");
    }

}
?>