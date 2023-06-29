<?php
namespace screenings;
use component\Component;
require_once("./template/component/component.php");

class Screenings extends Component {
    
    public function __construct(string $name) {
        parent::__construct($name);
    }

    public function load(): void {
        $filename = './template/component/screenings/html/' . $this->_name . '.template.html';
        if(file_exists($filename))
            $this->_template = file_get_contents($filename);
        else
            $this->_template = ' --> Error: this directory is not a file.';
    }
}
?>