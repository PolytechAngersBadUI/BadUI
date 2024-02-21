<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $operation = $_POST['operation'];
session_start(['cookie_lifetime' => 20,]);

// Check if the session variable exists
if (!isset($_SESSION['count'])) {
    $_SESSION['count'] = 0;
}

if($operation==2){
    $_SESSION['count']++;
}else if($operation==1){
    $_SESSION['count']--;}

// Send the new count back to JavaScript
echo 'here is your number : ' . $_SESSION['count'];
}
if($operation==3){
    include 'save_number.php';
}

