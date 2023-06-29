<?php
namespace admin;
require_once("./template/component/admin/admin.php");

class Menu extends Admin {

    private $_pagename;
    
    public function __construct(string $pagename ="") {
        $this->_pagename = $pagename;
        parent::__construct("menu");
        $this->build();
    }

    public function build() {
        $this->replaceTag("ADMIN", "admin" != $this->_pagename ? '<li><a href="admin.php">Pagina principale</a></li>' : '<li id="currentlink">Pagina principale</li>');
        $this->replaceTag("BOOKINGS", "admin_bookings" != $this->_pagename ? '<li><a href="admin_bookings.php">Gestione prenotazioni</a></li>' : '<li id="currentlink">Gestione prenotazioni</li>');
        $this->replaceTag("MOVIES", "admin_movies" != $this->_pagename ? '<li><a href="admin_movies.php">Gestione film</a></li>' : '<li id="currentlink">Gestione film</li>');
        $this->replaceTag("SCREENINGS", "admin_screenings" != $this->_pagename ? '<li><a href="admin_screenings.php">Gestione proiezioni</a></li>' : '<li id="currentlink">Gestione proiezioni</li>');
        $this->replaceTag("MESSAGES", "admin_messages" != $this->_pagename ? '<li><a href="admin_messages.php">Messaggi</a></li>' : '<li id="currentlink">Messaggi</li>');
    }
}