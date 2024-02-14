<?php
session_start(['cookie_lifetime' => 20,]);

// Check if the session variable exists
if (!isset($_SESSION['count'])) {
    $_SESSION['count'] = 0;
}

// Increment the session variable
$_SESSION['count']++;

// Send the new count back to JavaScript
echo 'here is your number : ' . $_SESSION['count'];
