<?php

class LatexSupportExtension extends Minz_Extension {
    public function init() {
        $this->loadMathjax();
        $this->registerHook('entry_before_display', array($this, 'sanitize'));
    }

    private function loadMathjax() {
        $config = 'mathjax-config.js';
        Minz_View::appendScript($this->getFileUrl($config, 'js'));
        $lib = 'mathjax/tex-chtml.js';
        Minz_View::appendScript($this->getFileUrl($lib, 'js'));
    }

    public function sanitize($entry) {
        $content = str_replace(array(
            '\\left⌊',
            '\\right⌋',
            '\\Complex',
            '\\Reals'
        ), array(
            '\\left\\lfloor',
            '\\right\\rfloor',
            '\mathbb{C}',
            '\mathbb{R}',
        ), $entry->content());

        $entry->_content($content);

        return $entry;
    }
}
