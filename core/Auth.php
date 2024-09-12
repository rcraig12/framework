<?php

// Authentication controller

class Auth {

  public static function isLoggedIn(){

    return isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true;

  }

  public static function login($username, $password) {

    // Ensure the session is started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Example credentials (these should be securely stored, e.g., in a database)
    $validUsername = 'admin';
    $hashedPassword = password_hash('password', PASSWORD_BCRYPT); // Securely hash the password

    // Validate the credentials
    if ($username === $validUsername && password_verify($password, $hashedPassword)) {
      
        $_SESSION['user_logged_in'] = true;
        $_SESSION['username'] = $username;

        // Successful login, clear CSRF token (optional)
        unset($_SESSION['csrf_token']);
        return true;

    } else {

        return false; // Invalid credentials

    }

  }

  public static function logout(){

    // Ensure the session is started
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    session_unset();

    // Unset all session variables
    $_SESSION = [];

    // Destroy the session
    session_destroy();

    // Optional: Regenerate session ID for extra security
    session_regenerate_id(true);

  }

}