<?php
// Receive the x and y coordinates from the client
$data = json_decode(file_get_contents('php://input'), true);
$x = $data['x'];
$y = $data['y'];

// Process the coordinates (you can add your logic here)

// Prepare the response data
$response = [
    'status' => 'success',
    'message' => 'Coordinates received successfully',
    'x' => $x,
    'y' => $y
];

// Send the response back to the client
header('Content-Type: application/json');
echo json_encode($response);
