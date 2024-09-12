<?php

class Page {

    public static function render($view, $data = []) {

        Theme::renderTemplate("page-" . strtolower($view), $data);  // Load view from the active theme

    }

}
