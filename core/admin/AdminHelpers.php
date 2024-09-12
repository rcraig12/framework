<?php
// core/Helpers.php
function fwHead()
{
  AdminTheme::renderHeader();
}

function fwFoot()
{
  AdminTheme::renderFooter();
}

// Add a hook
function add_hook($hook_name, $callback, $priority = 100, $args = [])
{
  Hook::add_hook($hook_name, $callback, $priority, $args);
}

// Remove a hook
function remove_hook($hook_name, $callback)
{
  Hook::remove_hook($hook_name, $callback);
}

// Execute a hook
function do_hook($hook_name, $args = [])
{
  Hook::do_hook($hook_name, $args);
}

// Special functions for header and footer hooks
function do_header()
{
  do_hook('header');
}

function do_footer()
{
  do_hook('footer');
}

// Add a filter
function add_filter($filter_name, $callback, $priority = 100, $args = [])
{
  Filter::add_filter($filter_name, $callback, $priority, $args);
}

// Remove a filter
function remove_filter($filter_name, $callback)
{
  Filter::remove_filter($filter_name, $callback);
}

// Apply a filter and return the filtered value
function do_filter($filter_name, $value, $args = [])
{
  return Filter::do_filter($filter_name, $value, $args);
}
