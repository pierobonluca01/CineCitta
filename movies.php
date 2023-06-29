<?php

use template\Template;
use component\Topbar;
use component\Breadcrumb;
use component\BreadcrumbElement;
use component\Component;
use movies\MovieList;

require_once("./template/template.php");
require_once("./template/component/topbar.component.php");
require_once("./template/component/breadcrumb.component.php");
require_once("./template/component/movies/movieList.component.php");

require_once("./model/connection.php");

$page = new Template("movies");
$page->replaceTag("SUBTITLE", "Film in sala");
$page->replaceTag("TOPBAR", new Topbar("movies"));
$breadcrumb=array(
    new BreadcrumbElement("Home", "index.php", "en"),
    new BreadcrumbElement("Film in sala", "#")
);
$page->replaceTag("MOVIES", new MovieList);
$page->replaceTag("BREADCRUMB", new Breadcrumb($breadcrumb));
$page->replaceTag("FOOTER", new Component("footer"));

echo $page;

?>