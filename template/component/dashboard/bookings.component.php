<?php

namespace dashboard;
use dashboard\Dashboard;
require_once("./template/component/dashboard/dashboard.php");

class Bookings extends Dashboard {

    public function __construct() {
        parent::__construct("bookings");
        $this->build();
    }

    public function build() {
        $this->_connection->connect();
        $bookings = $this->_connection->query("SELECT u.username, b.code, s.movie_title, s.theater_number, s.start_date, s.start_time, b.ordinary, b.reserved FROM `bookings` AS `b` JOIN `users` AS `u` ON b.user = u.id JOIN `screenings` AS `s` ON b.screen = s.id WHERE u.username = \"" . $_SESSION["username"] . "\" ORDER BY s.start_date DESC, s.start_time DESC; ");
        $rows = mysqli_num_rows($bookings);
        $this->_connection->disconnect();
        if($rows >= 1) {
            while($book = $bookings->fetch_row()) {
                $this->replaceTag("BOOKINGS", new Dashboard("bookingContainer"));
                $this->replaceValue("Code", $book[1]);
                $this->replaceValue("Title", $book[2]);
                $this->replaceValue("Theater", $book[3]);
                $this->replaceValue("Date", strftime("%d/%m/%Y", strtotime($book[4])));
                $this->replaceValue("Time", strftime("%H:%M", strtotime($book[5])));
                $this->replaceValue("Ordinary", $book[6]);
                $this->replaceValue("Reserved", $book[7]);
            }
            $this->replaceTag("BOOKINGS", "");
        } else {
            $this->replaceTag("BOOKINGS", "<p>Nessuna prenotazione. Dai un'occhiata alle <a href=\"screenings.php\">proiezioni</a>!</p>");
        }
    }
}