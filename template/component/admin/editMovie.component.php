<?php
namespace admin;
require_once("./template/component/admin/admin.php");

class EditMovie extends Admin {
    
    public function __construct() {
        parent::__construct("editMovie");
        $this->build();
    }

    public function message(string $message, string $class ="error") {
        $this->replaceTag("EDITMESSAGE", "<p id=\"message\" class=\"$class\" role=\"alert\">$message</p>");
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

        if(isset($_POST["edit-submit"])) {
            if(isset($_REQUEST["edit-title"])) {
                $this->_connection->connect();
                $title = $_REQUEST["edit-title"];
                $synopsis = $this->_connection->real_escape_string(trim(stripslashes($_REQUEST['edit-synopsis']),"<>"));
                $release_date = $_REQUEST['edit-release-date'];
                $duration = $_REQUEST['edit-duration'];
                $countries = $this->_connection->real_escape_string(trim(stripslashes($_REQUEST['edit-countries']),"<>"));
                if(is_uploaded_file($_FILES["edit-cover"]["tmp_name"])) {
                    $oldfile = $this->_connection->query("SELECT `cover` FROM `movies` WHERE `title` = '" . $_REQUEST["edit-title"] . "'")->fetch_row()[0];
                    $target_file = "./images/poster/" . basename($_FILES["edit-cover"]["name"]);
                    if(file_exists($target_file)) {
                        $this->message("L'immagine esiste già.");
                    } elseif($_FILES["edit-cover"]["size"] > 5000000) {
                        $this->message("L'immagine ha dimensioni troppo alte (>5MB).");
                    } elseif(strtolower(pathinfo($target_file, PATHINFO_EXTENSION)) != "jpg") {
                        $this->message("L'immagine non è in formato JPG.");
                    } elseif($this->_connection->query("UPDATE `movies` SET `cover` = '$target_file' WHERE `title` = '$title'")) {
                        unlink($oldfile);
                        move_uploaded_file($_FILES["edit-cover"]["tmp_name"], $target_file);
                    }
                }
                if($synopsis) {
                    if(strlen($synopsis) > 500)
                        $this->message("Il campo Sinossi supera i 500 caratteri.");
                    else
                        $this->_connection->query("UPDATE `movies` SET `synopsis` = '$synopsis' WHERE `title` = '$title'");
                }
                if($duration) {
                    $this->_connection->query("UPDATE `movies` SET `duration` = '$duration' WHERE `title` = '$title'");
                }
                if($release_date) {
                    $this->_connection->query("UPDATE `movies` SET `release_date` = '$release_date' WHERE `title` = '$title'");
                }
                if($countries) {
                    if(strlen($countries) > 100)
                        $this->message("Il campo Paesi di produzione supera i 100 caratteri.");
                    else
                        $this->_connection->query("UPDATE `movies` SET `countries` = '$countries' WHERE `title` = '$title'");
                }

                $this->_connection->disconnect();
                $this->message("Film aggiornato con successo.", "success");
            } else {
                $this->message("Nessun film selezionato.");
            }            
        } elseif(isset($_POST["delete"])) {
            if(isset($_REQUEST["edit-title"])) {
                $this->_connection->connect();
                $file = $this->_connection->query("SELECT `cover` FROM `movies` WHERE `title` = '" . $_REQUEST["edit-title"] . "'")->fetch_row()[0];
                if($file != null && $this->_connection->query("DELETE FROM `movies` WHERE `title` = '" . $_REQUEST["edit-title"] . "'")) {
                    unlink($file);
                    $this->message("Film eliminato con successo.", "success");
                } else {
                    $this->message("Errore in fase di eliminazione.");
                }
                $this->_connection->disconnect();
            } else {
                $this->message("Nessun film selezionato.");
            }
        } else {
            $this->replaceTag("EDITMESSAGE", "");
        }
    }
}