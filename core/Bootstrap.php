<?php

// includes for the framework core.

require_once APPROOT . '/core/Router.php';
require_once APPROOT . '/core/Hook.php';
require_once APPROOT . '/core/Filter.php';


// Setup the routes for the web system

require_once APPROOT . '/core/admin/AdminRoutes.php';
require_once APPROOT . '/config/routes.php';

// Plugin Manager Load
require_once APPROOT . '/core/PluginManager.php';
PluginManager::load_plugins();