<?php
namespace contacts;
require_once("./template/component/book/book.php");

class Form extends Contacts {
    
    public function __construct() {
        parent::__construct("form");
        $this->build();
    }

    public function message(string $message, string $id ="error") {
        $this->replaceTag("MESSAGE", "<p id=\"$id\" role=\"alert\">$message</p>");
    }

    public function build() {
        if(isset($_POST["submit"])) {
            $create_datetime = date("Y-m-d H:i:s");
            $this->_connection->connect();
            $name = $this->_connection->real_escape_string(stripslashes($_REQUEST['nome']));
            $surname = $this->_connection->real_escape_string(stripslashes($_REQUEST['cognome']));
            $email = $this->_connection->real_escape_string(stripslashes($_REQUEST['email']));
            $subject = $this->_connection->real_escape_string(stripslashes($_REQUEST['subject']));
            $text = $this->_connection->real_escape_string(stripslashes($_REQUEST['messaggio']));

            if($name == "" || $surname == "" || $email == "" || $text == "") {
                $this->message("Mancano alcuni campi.");
            } elseif(strlen($name) > 50 || strlen($surname) > 50 || strlen($email) > 100 || strlen($subject) > 100 || strlen($text) > 2000) {
                $this->message("Alcuni campi di testo superano il limite di caratteri consentito.");
            } elseif($this->_connection->query("INSERT INTO `messages` (`id`, `name`, `surname`, `mail`, `subject`, `content`, `time`) VALUES (NULL, '$name', '$surname', '$email', '$subject', '$text', '$create_datetime')")) {
                $this->message("Messaggio inviato con successo.", "success");
            }
            $this->_connection->disconnect();
        }
        $this->replaceTag("MESSAGE", "");
    }

}
?>