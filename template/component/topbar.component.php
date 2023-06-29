<?php
namespace component;
use component\Component;
require_once("./template/component/component.php");

class Topbar extends Component {

    private $_pagename;

    public function __construct(string $pagename = "") {
        $this->_pagename = $pagename;
        parent::__construct("topbar");
        $this->build();
    }

    public function build() : void {
        $this->replaceTag("LOGO", "index" != $this->_pagename ? '<a href="index.php">CineCitta</a>' : 'CineCitta');
        $this->replaceTag("HOME", "index" != $this->_pagename ? '<li><a href="index.php"><span lang="en">Home</span></a></li>' : '<li id="currentlink"><span lang="en">Home</span></li>');
        $this->replaceTag("PROIEZIONI", "screenings" != $this->_pagename ? '<li><a href="screenings.php">Proiezioni</a></li>' : '<li id="currentlink">Proiezioni</li>');
        $this->replaceTag("FILM", "movies" != $this->_pagename ? '<li><a href="movies.php">Film in sala</a></li>' : '<li id="currentlink">Film in sala</li>');
        $this->replaceTag("CONTATTI", "contacts" != $this->_pagename ? '<li><a href="contacts.php">Contatti</a></li>' : '<li id="currentlink">Contatti</li>');
        
        if(isset($_SESSION["username"])) {
            $login = "Area di ".$_SESSION["username"];
            $link = "dashboard";
            if(parent::isAdmin($_SESSION["username"])) {
                $login = "Area di amministrazione";
            $link = "admin";
            }            
        }
        else {
            $login = "Login";
            $link = "login";
        }
        $this->replaceTag("LOGIN", $link != $this->_pagename ? '<li><a href="'.$link.'.php">'.$login.'</a></li>' : '<li id="currentlink">'.$login.'</li>');
    }


}

?>
