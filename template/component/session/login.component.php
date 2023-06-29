<?php

namespace session;
use mysqli;
use session\Session;
require_once("./template/component/session/session.php");

class Login extends Session {

    public function __construct() {
        parent::__construct("login");
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
            $result = $this->_connection->query("SELECT * FROM users WHERE username='$username' AND password='" . hash("sha256", $password) . "'");
            if(mysqli_num_rows($result) == 1) {
                $_SESSION['username'] = $username;
                if($this->isAdmin($_SESSION['username']))
                    header("Location: admin.php");
                else
                    header("Location: dashboard.php");
            }
            else {
                $this->message("Username/password non corretti.");
            }
            $this->_connection->disconnect();
        }
        else {
            $this->replaceTag("ERROR", "");
        }
    }
}

?>