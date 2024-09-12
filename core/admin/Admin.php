<?php

class Admin {

  public static function render($view, $data = []) {
    AdminTheme::renderTemplate('admin-' . strtolower($view), $data);  // Load view from the active theme
  }

  private static function debugData($data){
    echo "<pre>";
    print_r($data);
    print_r($_SESSION);
    echo "</pre>";
  }

  public static function generateCsrfToken() {

      // Ensure the session is started
      if (session_status() === PHP_SESSION_NONE) {
          session_start();
      }

      // Always regenerate a CSRF token on every page load
      $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

  }

  public static function showLogin($view, $data = []) {

      // Ensure the session is started
      if (session_status() === PHP_SESSION_NONE) {
          session_start();
      }

      // Regenerate the CSRF token when the login form is loaded
      self::generateCsrfToken();

      if (Auth::isLoggedIn()) {
          // If the user is already logged in, redirect to the dashboard
          self::debugData($data);
          self::render('dashboard', $data);
          exit;
      }

      // Pass CSRF token to the view
      $data['csrf_token'] = $_SESSION['csrf_token'];

      // Show login form view
      self::render('login', $data);

  }

  public static function login($view, $data = []) {
    // Ensure the session is started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Check if the CSRF token matches
    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Invalid CSRF Token");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      // Check if the username and password are set
      if (isset($_POST['username']) && isset($_POST['password'])) {

        // Delegate login to the Auth class
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (Auth::login($username, $password)) {
            // Redirect to the dashboard after login
            header('Location: /fw-admin');
            exit;
        } else {
            echo "Invalid credentials.";
        }

      } else {
          echo "Username or password is not set.";
      }

    } else {

        echo "Invalid request method.";

    }

  }

  public static function showDashboard($view = 'dashboard', $data = []) {

      // Ensure the session is started
      if (session_status() === PHP_SESSION_NONE) {
          session_start();
      }

      // Regenerate the CSRF token on every page load
      self::generateCsrfToken();

      if (!Auth::isLoggedIn()) {
          header('Location: /fw-admin/login');
          exit;
      }

      // Render the dashboard
      self::render($view, $data);
      //self::debugData($data);

  }

  public static function logout() {

    Auth::logout();
    header('Location: /fw-admin');
    exit;

  }

}
