<?php

class Filter
{

  // Store all filters and their callbacks
  protected static $filters = [];

  /**
   * Add a filter
   *
   * @param string $filter_name The name of the filter
   * @param callable|string $callback The callback function or method
   * @param int $priority The priority (default is 100)
   * @param array $args Arguments to pass to the callback
   */
  public static function add_filter($filter_name, $callback, $priority = 100, $args = [])
  {
    // Ensure the filter has a callback array
    if (!isset(self::$filters[$filter_name])) {
      self::$filters[$filter_name] = [];
    }

    // Add the callback with priority and args
    self::$filters[$filter_name][] = [
      'callback' => $callback,
      'priority' => $priority,
      'args'     => $args
    ];

    // Sort filters by priority (lower number = higher priority)
    usort(self::$filters[$filter_name], function ($a, $b) {
      return $a['priority'] - $b['priority'];
    });
  }

  /**
   * Remove a specific callback from a filter
   *
   * @param string $filter_name The name of the filter
   * @param callable|string $callback The callback function or method
   */
  public static function remove_filter($filter_name, $callback)
  {
    if (isset(self::$filters[$filter_name])) {
      // Find and remove the callback
      foreach (self::$filters[$filter_name] as $key => $filter) {
        if ($filter['callback'] === $callback) {
          unset(self::$filters[$filter_name][$key]);
        }
      }

      // Re-index array after removing
      self::$filters[$filter_name] = array_values(self::$filters[$filter_name]);
    }
  }

  /**
   * Apply all filters registered to a filter
   *
   * @param string $filter_name The name of the filter
   * @param mixed $value The initial value to be filtered
   * @param array $args Additional arguments to pass to the callbacks
   * @return mixed The filtered value
   */
  public static function do_filter($filter_name, $value, $args = [])
  {
    if (isset(self::$filters[$filter_name])) {
      foreach (self::$filters[$filter_name] as $filter) {
        // Merge any filter-specific args with the passed args
        $all_args = array_merge([$value], $filter['args'], $args);

        // Call the callback and update the value with the result
        $value = call_user_func_array($filter['callback'], $all_args);
      }
    }
    return $value;
  }
}
