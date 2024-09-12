<?php

class PluginManager
{

  // Store registered plugins
  protected static $plugins = [];

  // Load and register all plugins from the app/plugins directory
  public static function load_plugins()
  {
    $plugin_dir = __DIR__ . '/../app/plugins/';

    // Scan the plugin directory
    $folders = scandir($plugin_dir);

    foreach ($folders as $folder) {
      if ($folder === '.' || $folder === '..') {
        continue;
      }

      $plugin_file = $plugin_dir . $folder . '/' . $folder . '.php';

      // Check if the expected plugin file exists
      if (file_exists($plugin_file)) {
        $plugin_data = self::get_plugin_data($plugin_file);

        if ($plugin_data) {
          self::$plugins[] = $plugin_data;
          // Include the plugin file to register hooks, filters, etc.
          require_once $plugin_file;
        }
      }
    }
  }

  // Parse the block comment for plugin metadata
  protected static function get_plugin_data($plugin_file)
  {
    $plugin_data = [];

    // Read the file content
    $file_content = file_get_contents($plugin_file);

    // Use a regular expression to extract the block comment
    if (preg_match('/\/\*\s*(.*?)\s*\*\//s', $file_content, $matches)) {
      $comment_block = $matches[1];

      // Parse the block comment line by line
      $lines = explode("\n", $comment_block);

      foreach ($lines as $line) {
        $line = trim($line);

        // Match plugin name, version, description, etc.
        if (strpos($line, 'Plugin Name:') === 0) {
          $plugin_data['name'] = trim(str_replace('Plugin Name:', '', $line));
        }
        if (strpos($line, 'Version:') === 0) {
          $plugin_data['version'] = trim(str_replace('Version:', '', $line));
        }
        if (strpos($line, 'Description:') === 0) {
          $plugin_data['description'] = trim(str_replace('Description:', '', $line));
        }
        if (strpos($line, 'Author:') === 0) {
          $plugin_data['author'] = trim(str_replace('Author:', '', $line));
        }
      }
    }

    // Return plugin data if valid, otherwise false
    return !empty($plugin_data) ? $plugin_data : false;
  }

  // Get all registered plugins
  public static function get_plugins()
  {
    return self::$plugins;
  }
}
