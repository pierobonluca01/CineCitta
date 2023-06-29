<?php
namespace admin;
require_once("./template/component/admin/admin.php");

class InsertMovie extends Admin {
    
    public function __construct() {
        parent::__construct("insertMovie");
        $this->build();
    }

    public function message(string $message, string $class ="error") {
        $this->replaceTag("INSERTMESSAGE", "<p id=\"message\" class=\"$class\" role=\"alert\">$message</p>");
    }

    public function build() {
        if(isset($_POST["insert-submit"])) {
            $this->_connection->connect();
            $title = $this->_connection->real_escape_string(trim(stripslashes($_REQUEST['insert-title']),"<>"));
            $synopsis = $this->_connection->real_escape_string(trim(stripslashes($_REQUEST['insert-synopsis']),"<>"));
            $release_date = $_REQUEST['insert-release-date'];
            $duration = $_REQUEST['insert-duration'];
            $countries = $this->_connection->real_escape_string(trim(stripslashes($_REQUEST['insert-countries']),"<>"));
            $target_file = "./images/poster/" . basename($_FILES["insert-cover"]["name"]);
            $result = $this->_connection->query("SELECT * FROM movies WHERE title='$title'");
            if(mysqli_num_rows($result)== 1) {
                $this->message("Il film esiste già.");
            } elseif($title == "" || $synopsis == "" || $release_date == "" || $duration == "" || $countries == "") {
                $this->message("Mancano alcuni campi.");
            } elseif(strlen($title) > 100 || strlen($title) < 1 || strlen($synopsis) > 500 || strlen($synopsis) < 1 || strlen($countries) > 100 || strlen($countries) < 1) {
                $this->message("Alcuni campi di testo non sono validi.");                
            } elseif(file_exists($target_file)) {
                $this->message("L'immagine esiste già.");
            } elseif($_FILES["insert-cover"]["size"] > 5000000) {
                $this->message("L'immagine ha dimensioni troppo alte (>5MB).");
            } elseif(strtolower(pathinfo($target_file, PATHINFO_EXTENSION)) != "jpg") {
                $this->message("L'immagine non è in formato JPG.");
            } elseif($this->_connection->query("INSERT INTO `movies` (`title`, `synopsis`, `release_date`, `duration`, `countries`, `cover`) VALUES ('$title', '$synopsis', '$release_date', '$duration', '$countries', '$target_file')")) {
                move_uploaded_file($_FILES["insert-cover"]["tmp_name"], $target_file);
                $this->message("Film inserito con successo.", "success");
            } else {
                $this->message("Errore generico.");
            }
            $this->_connection->disconnect();            
        } else {
            $this->replaceTag("INSERTMESSAGE", "");
        }
    }
}