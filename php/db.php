<?php
ini_set('display_errors', 1); // Enable error reporting for debugging
error_reporting(E_ALL); // Report all types of errors

if (session_status() === PHP_SESSION_NONE) { // Start session if not already started
  session_start();
}

$host = "localhost";
$dbname = "buildux";
$user = "postgres";
$password = "isen44N";

try { // Attempt to connect to the PostgreSQL database using PDO
  $pdo = new PDO( 
    "pgsql:host=$host;dbname=$dbname",
    $user,
    $password,
    [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Set error mode to exception for better error handling
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Set default fetch mode to associative array for easier data handling
    ]
  );
} catch (PDOException $e) { // Handle connection errors gracefully by outputting a JSON error message and exiting
  die("Erreur BDD : " . $e->getMessage()); // Output error message and terminate script
}

function is_logged_in(): bool { // Function to check if the user is logged in by checking the session variable
  return !empty($_SESSION["user"]);
}

function current_user(): ?array { // Function to retrieve the current logged-in user's information from the session, or return null if not logged in
  return $_SESSION["user"] ?? null;
}
