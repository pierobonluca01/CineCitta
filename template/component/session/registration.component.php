<?php

namespace session;
use mysqli;
use session\Session;
require_once("./template/component/session/session.php");

class Registration extends Session {

    public function __construct() {
        parent::__construct("registration");
        $this->build();
    }

    public function message(string $message, string $class ="error") {
        $this->replaceTag("ERROR", "<p id=\"message\" class=\"$class\" role=\"alert\">$message</p>");
    }

    public function build() {
        if(isset($_POST['username'])) {
            $this->_connection->connect();
            $username = $this->_connection->real_escape_string(stripslashes($_REQUEST['username']));
            $password = $this->_connection->real_escape_string(stripslashes($_REQUEST['password']));
            $repeat = $this->_connection->real_escape_string(stripslashes($_REQUEST['repeat']));
            $create_datetime = date("Y-m-d H:i:s");
            $result = $this->_connection->query("SELECT * FROM users WHERE username='$username'");
            $rows = mysqli_num_rows($result);
            if(strlen($username) >= 50) {
                $this->message("Il nome utente supera i 50 caratteri.");
            }
            elseif($username == "") {
                $this->message("Non hai inserito il nome utente.");
            }
            elseif(!preg_match("/^[a-zA-Z\d\\_]{4,50}$/", $username)) {
                $this->message("Il nome utente contiene caratteri non validi.");
            }
            elseif(!preg_match("/^[A-Za-z\d!@#$%^&\\*]{4,}$/", $password)) {
                $this->message("La <span lang=\"en\">password</span> contiene caratteri non validi.");
            }
            elseif($rows == 1) {
                $this->message("Il nome utente è già registrato.");
            }
            elseif($password == "") {
                $this->message("Non hai inserito la <span lang=\"en\">password</span>.");
            }
            elseif($password != $repeat) {
                $this->message("Le  <span lang=\"en\">password</span> non corrispondono.");
            }
            elseif($this->_connection->query("INSERT into users (username, password, create_datetime) VALUES ('$username', '" . hash("sha256", $password) . "', '$create_datetime')")) {
                $_SESSION['username'] = $username;
                $this->_connection->disconnect();
                header("Location: dashboard.php");
            }
            else {
                $this->message("Errore generico.");
            }
            $this->_connection->disconnect();
        }
        else {
            $this->replaceTag("ERROR", "");
        }
    }
}

?>