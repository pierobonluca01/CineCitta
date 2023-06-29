<?php
namespace admin;
require_once("./template/component/admin/admin.php");

class DeleteBookings extends Admin {
    
    public function __construct() {
        parent::__construct("deleteBookings");
        $this->build();
    }

    public function build() {
        $this->_connection->connect();
        $today = strftime("%Y-%m-%d");

        if(isset($_POST["delete-today"])) {
            if($this->_connection->query("DELETE b FROM `bookings` AS `b` JOIN `screenings` AS `s` ON b.screen = s.id WHERE `start_date` = '$today'")) {
                $this->replaceTag("MESSAGE", "<p class=\"success\" role=\"alert\">Prenotazioni eliminate con successo.");
            }
        }

        if(isset($_POST["delete-all"])) {
            if($this->_connection->query("DELETE b FROM `bookings` AS `b` JOIN `screenings` AS `s` ON b.screen = s.id WHERE `start_date` < '$today'")) {
                $this->replaceTag("MESSAGE", "<p class=\"success\" role=\"alert\">Prenotazioni eliminate con successo.");
            }
        }

        
        $result = $this->_connection->query("SELECT * FROM `bookings` AS `b` JOIN `screenings` AS `s` ON b.screen = s.id WHERE `start_date` = '$today'");
        $this->replaceValue("Today", mysqli_num_rows($result));
        $result = $this->_connection->query("SELECT * FROM `bookings` AS `b` JOIN `screenings` AS `s` ON b.screen = s.id WHERE `start_date` < '$today'");
        $this->replaceValue("Date", strftime("%d/%m/%Y", strtotime($today)-86400));
        $this->replaceValue("All", mysqli_num_rows($result));

        $this->_connection->disconnect();
    }
}