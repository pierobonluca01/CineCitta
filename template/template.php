<?php

namespace template;

class Template {

    protected $_name;
    protected $_template;

    public function __construct(string $name) {
        $this->_name = $name;
        $this->load();
    }

    public function load(): void {
        $filename = './template/html/' . $this->_name . '.template.html';
        if(file_exists($filename))
            $this->_template = file_get_contents($filename);
        else
            $this->_template = ' --> Error: this directory is not a file.';
    }

    public function replaceTag(string $tag, string $content): void {
        $this->_template = str_replace('<' . $tag . '/>', $content, $this->_template);
    }

    public function replaceValue(string $val, string $content =null): void {
        $this->_template = str_replace('<val' . $val . '/>', $content, $this->_template);
    }

    public function __toString(): string {
        return $this->_template;
    }
}

?>