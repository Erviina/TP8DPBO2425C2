<?php

class Template
{
    var $filename = '';
    var $content = '';

    function __construct($filename = '')
    {
        // path menuju /templates/
        $path = __DIR__ . '/../templates/' . $filename;

        if (!file_exists($path)) {
            die("Template file not found: " . $path);
        }

        $this->filename = $path;
        $this->content = implode("", file($path));
    }

    function clear()
    {
        $this->content = preg_replace("/DATA_[A-Z|_|0-9]+/", "", $this->content);
    }

    function write()
    {
        $this->clear();
        print $this->content;
    }

    function replace($old = '', $new = '')
    {
        if (is_int($new)) {
            $value = sprintf("%d", $new);
        } else {
            $value = $new;
        }

        $this->content = preg_replace("/$old/", $value, $this->content);
    }
}
