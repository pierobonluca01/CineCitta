<?php

use template\Template;
use component\Topbar;
use component\Breadcrumb;
use component\BreadcrumbElement;
use component\Component;
use movie\MovieInfo;
use movie\MovieScreenings;

require_once("./template/template.php");
require_once("./template/component/topbar.component.php");
require_once("./template/component/breadcrumb.component.php");
require_once("./template/component/movie/movieInfo.component.php");
require_once("./template/component/movie/movieScreenings.component.php");

require_once("./model/connection.php");

if(!isset($_GET["title"]))
    header("Location: screenings.php");

$page = new Template("movie");
$page->replaceTag("SUBTITLE", $_GET["title"]);
$page->replaceValue("Title",$_GET["title"]);
$page->replaceTag("TOPBAR", new Topbar);
if(isset($_GET["from"]) && $_GET["from"] == "screenings") {
    $breadcrumb=array(
        new BreadcrumbElement("Home", "index.php", "en"),
        new BreadcrumbElement("Proiezioni", "screenings.php"), 
        new BreadcrumbElement($_GET["title"], "#")
    );
} else {
    $breadcrumb=array(
        new BreadcrumbElement("Home", "index.php", "en"),
        new BreadcrumbElement("Film in sala", "movies.php"), 
        new BreadcrumbElement($_GET["title"], "#")
    );
}
$page->replaceTag("BREADCRUMB", new Breadcrumb($breadcrumb));
$page->replaceTag("MOVIE", new MovieInfo);
$page->replaceTag("SCREENINGS", new MovieScreenings);
$page->replaceTag("FOOTER", new Component("footer"));

echo $page;

?>