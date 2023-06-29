<?php

namespace dashboard;
use dashboard\Dashboard;
require_once("./template/component/dashboard/dashboard.php");

class Settings extends Dashboard {

    public function __construct() {
        parent::__construct("settings");
        $this->build();
    }

    public function build() {
        $this->_connection->connect();
        $creation_date = $this->_connection->query("SELECT `create_datetime` FROM `users` WHERE `username` = '" . $_SESSION["username"] . "'");
        $creation_date = $creation_date->fetch_row()[0];
        $this->replaceValue("Date", $creation_date);
        $this->replaceValue("AccountDate", strftime("%d/%m/%Y", strtotime($creation_date)));
        $this->replaceValue("AccountTime", strftime("%H:%M", strtotime($creation_date)));
        $this->_connection->disconnect();

        if(isset($_POST["submit-username"])) {
            $this->_connection->connect();
            $id = $this->_connection->query("SELECT `id` FROM users WHERE username=\"" . $_SESSION["username"] . "\"");
            $id = $id->fetch_row()[0];
            $username = $this->_connection->real_escape_string(stripslashes($_REQUEST['username']));
            $result = $this->_connection->query("SELECT * FROM users WHERE username='$username'");
            $rows = mysqli_num_rows($result);
            
            if(strlen($username) >= 50) {
                $this->replaceTag("ERRORUSERNAME", "<p class=\"error\" role=\"alert\">Il nome utente supera i 50 caratteri.</p>");
            } elseif($username == "") {
                $this->replaceTag("ERRORUSERNAME", "<p class=\"error\" role=\"alert\">Non hai inserito il nome utente.</p>");
            } elseif($rows == 1) {
                $this->replaceTag("ERRORUSERNAME", "<p class=\"error\" role=\"alert\">Il nome utente è già in uso.</p>");
            } elseif($this->_connection->query("UPDATE `users` SET `username` = '$username' WHERE `id` = '$id'")) {
                $_SESSION["username"] = $username;
                $this->_connection->disconnect();
                header("Location: dashboard.php");
            } else {
                $this->replaceTag("ERRORUSERNAME", "<p class=\"error\" role=\"alert\">Errore generico.</p>");
            }
            $this->_connection->disconnect();
        } else {
            $this->replaceTag("ERRORUSERNAME", "");
        }

        if(isset($_POST["submit-password"])) {
            $this->_connection->connect();
            $old_password = $this->_connection->real_escape_string(stripslashes($_REQUEST['old-password']));
            $new_password = $this->_connection->real_escape_string(stripslashes($_REQUEST['new-password']));
            $repeat = $this->_connection->real_escape_string(stripslashes($_REQUEST['repeat']));
            $result = $this->_connection->query("SELECT * FROM users WHERE username='" . $_SESSION["username"] . "' AND password='" . hash("sha256", $old_password) . "'");
            if (mysqli_num_rows($result) != 1) {
                $this->replaceTag("ERRORPASSWORD", "<p class=\"error\" role=\"alert\">La <span lang=\"en\">password</span> attualmente in uso non è corretta.</p>");
            } elseif($old_password == "" || $new_password == "" || $repeat == "") {
                $this->replaceTag("ERRORPASSWORD", "<p class=\"error\" role=\"alert\">Non hai inserito un campo.</p>");
            } elseif($new_password != $repeat) {
                $this->replaceTag("ERRORPASSWORD", "<p class=\"error\" role=\"alert\">Le <span lang=\"en\">password</span> non corrispondono.</p>");
            } elseif($this->_connection->query("UPDATE `users` SET `password` = '" . hash("sha256", $new_password) . "' WHERE `username` = '" . $_SESSION["username"] . "'")) {
                $this->replaceTag("ERRORPASSWORD", "<p class=\"error\" id=\"success\" role=\"alert\">Cambio <span lang=\"en\">password</span> avvenuto con successo.</p>");
            } else {
                $this->replaceTag("ERRORPASSWORD", "<p class=\"error\" role=\"alert\">Errore generico.</p>");
            }
            $this->_connection->disconnect();
        } else {
            $this->replaceTag("ERRORPASSWORD", "");
        }
    }
}
?>