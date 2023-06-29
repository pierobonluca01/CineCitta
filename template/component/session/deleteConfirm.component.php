<?php

namespace session;
use mysqli;
use session\Session;
require_once("./template/component/session/session.php");

class DeleteConfirm extends Session {

    public function __construct() {
        parent::__construct("deleteConfirm");
        $this->build();
    }

    public function build() {
        if(isset($_POST['confirm-submit'])) {
            $username = $_SESSION['username'];
            $this->_connection->connect();
            $result = $this->_connection->query("DELETE FROM users WHERE username='$username';");
            session_destroy();
            $this->replaceTag("DELETEBOX", new Session("deleted"));
        }
        elseif(isset($_POST['deny-submit'])) {
            header("Location: dashboard.php");
        }
        else {
            $this->replaceTag("DELETEBOX", new Session("deletePrompt"));
        }
        
    }
}

?>