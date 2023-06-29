<?php
namespace component;
use component\Component;
require_once("./template/component/component.php");

class BreadcrumbElement {
    private $_name;
    private $_link;
    private $_lang;

    public function __construct(string $name, string $link, string $lang ="it") {
        $this->_name = $name;
        $this->_link = $link;
        $this->_lang = $lang;
    }

    public function getName() {
        return $this->_name;
    }

    public function getLink() {
        return $this->_link;
    }

    public function getLang() {
        return $this->_lang;
    }
}

class Breadcrumb extends Component {

    private $_elements;

    public function __construct(array $elements) {
        parent::__construct("breadcrumb");
        $this->_elements = $elements;
        $this->build();
    }

    public function build() : void {
        $last = end($this->_elements);
        $path = "";
        foreach($this->_elements as $e) {
            $name = $e->getName();
            $lang = $e->getLang();
            $link = $e->getLink();

            if($lang != "it") {
                $name = "<span lang=\"" . $lang . "\">" . $name . "</span>";
            }
            $path = $e != $last ? $path . "<li><a href=\"" . $link . "\">" . $name . "</a></li> " : $path . "<li>" . $name . "</li> ";
        }
        $this->replaceTag("PATH", $path);
    }


}

?>
