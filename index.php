<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

define ('APPROOT' , __DIR__ );

require_once __DIR__ . '/core/Router.php';
require_once __DIR__ . '/core/admin/AdminRoutes.php';
require_once __DIR__ . '/config/routes.php';

Router::dispatch($_SERVER['REQUEST_URI'] ?? '');
