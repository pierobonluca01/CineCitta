<?php
namespace book;
require_once("./template/component/book/book.php");

class ScreenForm extends Book {
    
    public function __construct() {
        parent::__construct("screenForm");
        $this->build();
    }

    public function build() {
        if(isset($_POST["delete"])) {
            $this->_connection->connect();
            $this->_connection->query("DELETE FROM `bookings` WHERE `code` = \"". $_POST["code"] ."\"");
            $this->_connection->disconnect();
            header("Location: admin.php");
        }

        if(isset($_POST["delete-screening"])) {
            $this->_connection->connect();
            $this->_connection->query("DELETE FROM `screenings` WHERE `movie_title`=\"" . addslashes($_POST["title"]) . "\" AND `start_date`=\"" . $_POST["date"] . "\" AND `start_time`=\"" . $_POST["time"] . "\"");
            $this->_connection->disconnect();
            header("Location: screenings.php");
        }
        
        if(isset($_POST["submit"])) {
            $this->book();
        } elseif(isset($_GET["code"])) {
            $this->view();
        } else {
            if(!isset($_GET["date"]) || !isset($_GET["title"]) || !isset($_GET["time"])) {
                header("Location: screenings.php");
            }
            $this->replaceValue("Title", $_GET["title"]);
            $this->replaceValue("Date", strftime("%d/%m/%Y", strtotime($_GET["date"])));
            $this->replaceValue("Time", strftime("%H:%M", strtotime($_GET["time"])));
            if($this->isAdmin($_SESSION["username"])) {
                $this->replaceTag("FORM", new Book("deleteScreening"));
                $this->replaceValue("Title", $_GET["title"]);
                $this->replaceValue("Date", $_GET["date"]);
                $this->replaceValue("Time", $_GET["time"]);
            }
            else
                $this->user_form();
        }
    }

    public function book() {
        $this->replaceValue("Title", $_POST["title"]);
        $this->replaceValue("Date", strftime("%d/%m/%Y", strtotime($_POST["date"])));
        $this->replaceValue("Time", strftime("%H:%M", strtotime($_POST["time"])));
        $this->replaceTag("FORM", new Book("booked"));
        $this->replaceValue("Username", $_POST["username"]);
        $this->replaceValue("Ordinary", $_POST["ordinary"]);
        $this->replaceValue("Reserved", $_POST["reserved"]);
        $this->replaceValue("Theater", $_POST["theater"]);
        $this->replaceTag("ADMIN", "");
        
        $code = "";
        do {
            $code = chr(rand(65, 90)) . chr(rand(65, 90)) . chr(rand(65, 90)) . chr(rand(65, 90));
            $this->_connection->connect();
            $result = $this->_connection->query("SELECT * FROM `bookings` WHERE `code` = \"". $code ."\"");
            $rows = mysqli_num_rows($result);
            $this->_connection->disconnect();
        } while($rows!=0);
        
        $this->_connection->connect();
        $user_id = $this->_connection->query("SELECT `id` FROM `users` WHERE `username` = \"" . $_POST["username"] . "\"");
        $screen_id = $this->_connection->query("SELECT `id` FROM `screenings` WHERE `movie_title`=\"" . addslashes($_POST["title"]) . "\" AND `start_date`=\"" . $_POST["date"] . "\" AND `start_time`=\"" . $_POST["time"] . "\"");
        if(mysqli_num_rows($screen_id)==1 && mysqli_num_rows($user_id)==1) {
            $user_id = $user_id->fetch_row()[0];
            $screen_id = $screen_id->fetch_row()[0];
            $check_screen = $this->_connection->query("SELECT * FROM `users` AS `u` JOIN `bookings` AS `b` ON u.id = b.user WHERE u.username = \"" . $_POST["username"] . "\" AND b.screen = \"" . $screen_id . "\"");
            if(mysqli_num_rows($check_screen)==0) {
                $this->_connection->query("INSERT INTO `bookings` (`code`, `user`, `screen`, `ordinary`, `reserved`) VALUES ('" . $code . "', '" . $user_id . "', '" . $screen_id . "', '" . $_POST["ordinary"] . "', '" . $_POST["reserved"] . "')");
                $this->replaceValue("Code", $code);
            } else
                $this->replaceValue("Code", "ERROR");
        } else 
            $this->replaceValue("Code", "ERROR");
        $this->_connection->disconnect();
    }

    public function view() {
        $this->_connection->connect();
        $booking = $this->_connection->query("SELECT `code`, `ordinary`, `reserved`, `username`, `movie_title`, `theater_number`, `start_date`, `start_time` FROM `bookings` AS `b` JOIN `users` AS `u` ON b.user = u.id JOIN `screenings` AS `s` ON b.screen = s.id WHERE b.code = \"" . $_GET["code"] . "\"");
        if(mysqli_num_rows($booking)!=1)
            $this->replaceTag("FORM", "<p><strong>Non esiste alcuna prenotazione associata a questo codice.</strong></p> <p>&lArr; <a href=\"admin.php\">Ritorna all'area di amministrazione.</a></p>");
        else {
            $booking = $booking->fetch_row();
            $this->replaceValue("Title", $booking[4]);
            $this->replaceValue("Date", strftime("%d/%m/%Y", strtotime($booking[6])));
            $this->replaceValue("Time", strftime("%H:%M", strtotime($booking[7])));
            $this->replaceTag("FORM", new Book("booked"));
            $this->replaceValue("Username", $booking[3]);
            $this->replaceValue("Ordinary", $booking[1]);
            $this->replaceValue("Reserved", $booking[2]);
            $this->replaceValue("Theater", $booking[5]);
            $this->replaceValue("Code", $booking[0]);
        }
        $this->_connection->disconnect();

        if($this->isAdmin($_SESSION["username"])) {
            $this->replaceTag("ADMIN", new Book("deleteBooking"));
            $this->replaceValue("Code", $_GET["code"]);
        }
    }

    public function user_form() {
        $this->_connection->connect();
        $screen = $this->_connection->query("SELECT `id`, `theater_number` FROM `screenings` WHERE `movie_title`=\"" . addslashes($_GET["title"]) . "\" AND `start_date`=\"" . $_GET["date"] . "\" AND `start_time`=\"" . $_GET["time"] . "\"");
        $today = strftime("%Y-%m-%d %H:%M");
        $screen_date = strftime("%Y-%m-%d %H:%M", strtotime($_GET["date"] . "  " . $_GET["time"]));
        if(mysqli_num_rows($screen)==1 && $screen_date>$today) {
            $screen = $screen->fetch_row();
            $screen_id = $screen[0];
            $screen_theater = $screen[1];

            $check_screen = $this->_connection->query("SELECT * FROM `users` AS `u` JOIN `bookings` AS `b` ON u.id = b.user WHERE u.username = \"" . $_SESSION["username"] . "\" AND b.screen = \"" . $screen_id . "\"");
            if(mysqli_num_rows($check_screen)==0) {
                $seats = $this->_connection->query("SELECT `ordinary`, `reserved` FROM `theaters` WHERE `number` = " . $screen_theater);
                $seats_booked = $this->_connection->query("SELECT `screen`, SUM(`ordinary`), SUM(`reserved`) FROM `bookings` WHERE `screen` = '" . $screen_id . "' GROUP BY `screen`");
                if(mysqli_num_rows($seats)==1) {
                    $seats = $seats->fetch_row();
                    $ordinary = $seats[0];
                    $reserved = $seats[1];
                    $ordinary_booked = 0;
                    $reserved_booked = 0;
                    if(mysqli_num_rows($seats_booked)==1) {
                        $seats_booked = $seats_booked->fetch_row();
                        $ordinary_booked = $seats_booked[1];
                        $reserved_booked = $seats_booked[2];
                    }
                    $ordinary_left = $ordinary-$ordinary_booked;
                    $reserved_left = $reserved-$reserved_booked;
                    if($ordinary_left==0 && $reserved_left==0) {
                        $this->replaceTag("FORM", "<p><strong>POSTI ESAURITI per questa proiezione.</strong></p>");
                    } else {
                        $this->replaceTag("FORM", new Book("seatsForm"));
                        $this->replaceValue("PostiOrdinari", $ordinary_left);
                        $this->replaceValue("PostiRiservati", $reserved_left);
                        $this->replaceValue("Username", $_SESSION["username"]);
                        $this->replaceValue("Title", $_GET["title"]);
                        $this->replaceValue("Date", $_GET["date"]);
                        $this->replaceValue("Time", $_GET["time"]);
                        $this->replaceValue("Theater", $screen_theater);
                        
                        $ordinary_max = $ordinary_left;
                        $ordinary_min = 0;
                        $reserved_max = $reserved_left;
                        $reserved_min = 0;
                        if($reserved_left==0)
                            $ordinary_min = 1;
                        if($ordinary_left==0)
                            $reserved_min = 1;
                        if($ordinary_left>=10)
                            $ordinary_max = 10;
                        
                        $this->replaceValue("OrdinaryMax", $ordinary_max);
                        $this->replaceValue("OrdinaryMin", $ordinary_min);
                        $this->replaceValue("ReservedMax", $reserved_max);
                        $this->replaceValue("ReservedMin", $reserved_min);
                    }
                }
            } else {
                $this->replaceTag("FORM", "<p><strong>Hai già una prenotazione per questa proiezione.</strong></p>");
            }
        } else {
            $this->replaceTag("FORM", "<p><strong>La proiezione selezionata non è più disponibile.</strong></p>");
        }
        $this->_connection->disconnect();
    }

}
?>