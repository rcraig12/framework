<?php

class Hook
{

  // Store all hooks and their callbacks
  protected static $hooks = [];

  /**
   * Add a hook
   *
   * @param string $hook_name The name of the hook
   * @param callable|string $callback The callback function or method
   * @param int $priority The priority (default is 100)
   * @param array $args Arguments to pass to the callback
   */
  public static function add_hook($hook_name, $callback, $priority = 100, $args = [])
  {
    // Ensure the hook has a callback array
    if (!isset(self::$hooks[$hook_name])) {
      self::$hooks[$hook_name] = [];
    }

    // Add the callback with priority and args
    self::$hooks[$hook_name][] = [
      'callback' => $callback,
      'priority' => $priority,
      'args'     => $args
    ];

    // Sort hooks by priority (lower number = higher priority)
    usort(self::$hooks[$hook_name], function ($a, $b) {
      return $a['priority'] - $b['priority'];
    });
  }

  /**
   * Remove a specific callback from a hook
   *
   * @param string $hook_name The name of the hook
   * @param callable|string $callback The callback function or method
   */
  public static function remove_hook($hook_name, $callback)
  {
    if (isset(self::$hooks[$hook_name])) {
      // Find and remove the callback
      foreach (self::$hooks[$hook_name] as $key => $hook) {
        if ($hook['callback'] === $callback) {
          unset(self::$hooks[$hook_name][$key]);
        }
      }

      // Re-index array after removing
      self::$hooks[$hook_name] = array_values(self::$hooks[$hook_name]);
    }
  }

  /**
   * Execute all callbacks registered to a hook
   *
   * @param string $hook_name The name of the hook
   * @param array $args Additional arguments to pass to the callbacks
   */
  public static function do_hook($hook_name, $args = [])
  {
    if (isset(self::$hooks[$hook_name])) {
      foreach (self::$hooks[$hook_name] as $hook) {
        // Merge any hook-specific args with the passed args
        $all_args = array_merge($hook['args'], $args);

        // Call the callback with the arguments
        call_user_func_array($hook['callback'], $all_args);
      }
    }
  }
}
