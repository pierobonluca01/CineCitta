<?php
namespace admin;
require_once("./template/component/admin/admin.php");

class Messages extends Admin {
    
    public function __construct() {
        parent::__construct("messages");
        $this->build();
    }

    public function build() {
        if(isset($_POST["delete-message"])) {
            $this->_connection->connect();
            $this->_connection->query("DELETE FROM `messages` WHERE `id` = '" . $_REQUEST["id"] . "'");
            $this->_connection->disconnect();
        } 

        $this->_connection->connect();
        $messages = $this->_connection->query("SELECT * FROM `messages` ORDER BY `time` DESC");
        if(mysqli_num_rows($messages) > 0) {
            while($msg = $messages->fetch_row()) {
                $this->replaceTag("MESSAGE", new Admin("messageContainer"));
                $this->replaceValue("Id", $msg[0]);
                $this->replaceValue("Subject", $msg[4]);
                $this->replaceValue("Name", $msg[1]);
                $this->replaceValue("Surname", $msg[2]);
                $this->replaceValue("Mail", $msg[3]);
                $this->replaceValue("Date", $msg[6]);
                $this->replaceValue("FormattedDate", strftime("%d/%m/%Y", strtotime($msg[6])));
                $this->replaceValue("Time", strftime("%H:%M", strtotime($msg[6])));
                $this->replaceValue("Content", $msg[5]);
            }
            $this->replaceTag("MESSAGE", "");
        } else {
            $this->replaceTag("MESSAGE", "<div class=\"session-popup\"><p>Nessun messaggio.</p></div>");
        }
        $this->_connection->disconnect();
    }
}