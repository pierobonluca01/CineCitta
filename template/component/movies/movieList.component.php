<?php
namespace movies;
use movies\Movies;
use movies\MovieItem;
require_once("./template/component/movies/movies.php");
require_once("./template/component/movies/movieItem.component.php");

class MovieList extends Movies {
    
    public function __construct() {
        parent::__construct("movieList");
        $this->build();
    }

    public function build() {
        $this->_connection->connect();
        if(isset($_GET["movie-search-bar"])) {
            $this->replaceTag("RICERCA", "<p>Filtro ricerca: \"<strong>" .  $_GET["movie-search-bar"] . "</strong>\". <a href=\"movies.php\">Rimuovi il filtro.</a></p>");
            $result = $this->_connection->query("SELECT * FROM movies WHERE `title` LIKE \"%" . $this->_connection->real_escape_string(stripslashes($_GET["movie-search-bar"])) . "%\" ORDER BY `title` ASC");
        }
        else {
            $this->replaceTag("RICERCA", "");
            $result = $this->_connection->query("SELECT * FROM movies ORDER BY `title` ASC");
        }
        while($entry = $result->fetch_row()) {
            $this->replaceTag("MOVIEITEM", new MovieItem($entry));
        }
        $this->replaceTag("MOVIEITEM", "");
        $result->free_result();
        $this->_connection->disconnect();
    }

}
?>