<?php
namespace screenings;
use screenings\ScheduleContainer;
require_once("./template/component/screenings/screenings.php");
require_once("./template/component/screenings/scheduleContainer.component.php");

class Schedule extends Screenings {

    private $_start_date;
    
    public function __construct() {
        parent::__construct("schedule");
        $this->_start_date = $_GET["date"];
        $this->build();
    }

    public function build() {
        $this->_connection->connect();
        $result = $this->_connection->query("SELECT DISTINCT `movie_title` FROM `screenings` WHERE `start_date` = '" . $this->_start_date . "'");
        $rows = mysqli_num_rows($result);
        $this->_connection->disconnect();
        if ($rows >= 1) {
            while($movie = $result->fetch_row())
                $this->replaceTag("SCHEDULECONTAINER", new ScheduleContainer($movie[0], $this->_start_date));
            $this->replaceTag("SCHEDULECONTAINER", "");
        }
        else
            $this->replaceTag("SCHEDULECONTAINER", "<p id=\"no-screenings\">Nessuna proiezione</p>");
    }
}
?>