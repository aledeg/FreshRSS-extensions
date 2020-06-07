<?php

class LatexSupportExtension extends Minz_Extension {
    public function init() {
        $this->loadMathjax();
    }

    private function loadMathjax() {
        $config = 'mathjax-config.js';
        Minz_View::appendScript($this->getFileUrl($config, 'js'));
        $lib = 'mathjax/tex-chtml.js';
        Minz_View::appendScript($this->getFileUrl($lib, 'js'));
    }
}
