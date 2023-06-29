<?php
namespace admin;
require_once("./template/component/admin/admin.php");

class InsertScreening extends Admin {
    
    public function __construct() {
        parent::__construct("insertScreening");
        $this->build();
    }

    public function message(string $message, string $class ="error") {
        $this->replaceTag("INSERTMESSAGE", "<p id=\"message\" class=\"$class\" role=\"alert\">$message</p>");
    }

    public function build() {
        $this->_connection->connect();
        $movies = $this->_connection->query("SELECT DISTINCT `title` FROM `movies`");
        $rows = mysqli_num_rows($movies);
        $this->_connection->disconnect();
        if($rows >= 1) {
            while($movie = $movies->fetch_row())
                $this->replaceTag("TITLE", "<option value=\"" .  addslashes($movie[0]) . "\"<valSelected/>" . $movie[0] . "</option>\n<TITLE/>");
            $this->replaceTag("TITLE", "<option value=\"\" selected disabled hidden>Film</option>");
        } else {
            $this->replaceTag("TITLE", "<option value=\"\" selected disabled hidden>Nessun film</option>");
        }

        if(isset($_POST["insert-submit"])) {
            $this->_connection->connect();
            $title = $_POST["title"];
            $theater = $_POST["theater"];
            $date = $_POST["date"];
            $time = $_POST["time"];
            $screen = $this->_connection->query("SELECT * FROM `screenings` WHERE `movie_title` = '$title' AND `start_date` = '$date' AND `start_time` = '$time'");
            if(mysqli_num_rows($screen) == 0) {
                if($this->_connection->query("INSERT INTO `screenings` (`id`, `movie_title`, `theater_number`, `start_date`, `start_time`) VALUES (NULL, '$title', '$theater', '$date', '$time')"))
                    $this->message("Proiezione inserita con successo.", "success");
            } else {
                $this->message("La proiezione esiste già.");
            }
            $this->_connection->disconnect();
        } else {
            $this->replaceTag("INSERTMESSAGE", "");
        }
    }
}