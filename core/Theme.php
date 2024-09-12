<?php

class Theme {

    private static $data = [];
    protected static $themeName = "";

    public static function renderTemplate($template, $data = []) {

        // Load the theme configuration
        $config = require_once APPROOT . '/config/config.php';
        self::$themeName = $config['theme'];

        // Store the data in a static property to make it accessible globally
        self::$data = $data;

        // Build the path to the template file
        $templatePath = APPROOT .  "/app/themes/" . self::$themeName . "/$template.php";

        if (file_exists($templatePath)) {

            // Make variables available to the view
            extract(self::$data);
            require_once $templatePath;

        } else {

            echo "View $templatePath not found!";

        }

    }


    // Method to render header (fwHead equivalent)
    public static function renderHeader() {

        // Build the path to the template file
        $templatePath = APPROOT .  "/app/themes/" . self::$themeName . "/header.php";

        if (file_exists($templatePath)) {

            // Make variables available to the view
            extract(self::$data);
            require_once $templatePath;

        } else {

            echo "View $templatePath not found!";

        }
    }


    // Method to render footer (fwFoot equivalent)
    public static function renderFooter() {

        // Build the path to the template file
        $templatePath = APPROOT .  "/app/themes/" . self::$themeName . "/footer.php";

        if (file_exists($templatePath)) {

            // Make variables available to the view
            extract(self::$data);
            require_once $templatePath;

        } else {

            echo "View $templatePath not found!";

        }

    }

}
