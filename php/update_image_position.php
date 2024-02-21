<?php
// Receive the x and y coordinates from the client
session_start(['cookie_lifetime' => 20000,]);
$data = json_decode(file_get_contents('php://input'), true);
$x = $data['x'];
$y = $data['y'];

// Check if the session variable exists
if (!isset($_SESSION['xr'])) {
    $_SESSION['count']=0;
    $_SESSION['xr'] = rand(0, 100);
    $_SESSION['yr'] = rand(0, 100);
    $response = [
        'status' => 'success1',
        'message' => 'New rectangle coordinates generated. Place the image on it. You have 30 secs to do the maximum points',
        'x' => $x,
        'y' => $y,
        'xr' => $_SESSION['xr'],
        'yr' => $_SESSION['yr']
    ];
} elseif ($x < $_SESSION['xr'] + 50 && $x > $_SESSION['xr'] - 50 && $y < $_SESSION['yr'] + 50 && $y > $_SESSION['yr'] - 50) {
    $_SESSION['xr'] = rand(0, 1000);
    $_SESSION['yr'] = rand(0, 1000);
    $_SESSION['count']++;
    $response = [
        'status' => 'success2',
        'message' => 'image successfully placed. New rectangle coordinates generated.',
        'x' => $x,
        'y' => $y,
        'xr' => $_SESSION['xr'],
        'yr' => $_SESSION['yr']
    ];
} else {
    $response = [
        'status' => 'success',
        'message' => 'Coordinates received successfully',
        'x' => $x,
        'y' => $y
    ];
}

// Send the response back to the client
header('Content-Type: application/json');
echo json_encode($response);

