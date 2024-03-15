<?php
// Receive the x and y coordinates from the client
session_start(['cookie_lifetime' => 20000,]);
$data = json_decode(file_get_contents('php://input'), true);
$x = $data['x'];
$y = $data['y'];

// Define the path coordinates
$path = [
    ['x' => 100, 'y' => 100],
    ['x' => 400, 'y' => 100],
    ['x' => 400, 'y' => 400],
    ['x' => 100, 'y' => 400]
];

// Check if the image is inside the path
if (isInsidePath($x, $y, $path) && isClosetoPreviousPoint($x, $y, $_SESSION['xp'], $_SESSION['yp'])) {
    $response['status'] = 'in';
    $response['message'] = 'Image is inside the path';
    $response['x'] = $x;
    $response['y'] = $y;
    $_SESSION['xp'] = $x;
    $_SESSION['yp'] = $y;
} else if(!isClosetoPreviousPoint($x, $y, $_SESSION['xp'], $_SESSION['yp'])) {
    $response['status'] = 'toofar';
    $response['message'] = 'Image was dragged too far from the previous point, user may be cheating';
    $response['x_out'] = $x;
    $response['y_out'] = $y;
    $response['x'] = 250;
    $response['y'] = 250;
    $_SESSION['xp'] = 250;
    $_SESSION['yp'] = 250;
}else{
    $response['status'] = 'out';
    $response['message'] = 'Image is not inside the path';
    $response['x_out'] = $x;
    $response['y_out'] = $y;
    $response['x'] = 250;
    $response['y'] = 250;
    $_SESSION['xp'] = 250;
    $_SESSION['yp'] = 250;
}

/**
 * Check if a point is inside a polygon defined by its vertices.
 * @param int $x The x-coordinate of the point
 * @param int $y The y-coordinate of the point
 * @param array $vertices The vertices of the polygon
 * @return bool True if the point is inside the polygon, false otherwise
 */

function isInsidePath($x, $y, $vertices) {
    $intersections = 0;
    $verticesCount = count($vertices);

    for ($i = 0; $i < $verticesCount; $i++) {
        $j = ($i + 1) % $verticesCount;
        if (($vertices[$i]['y'] > $y) !== ($vertices[$j]['y'] > $y) &&
            $x < ($vertices[$j]['x'] - $vertices[$i]['x']) * ($y - $vertices[$i]['y']) / ($vertices[$j]['y'] - $vertices[$i]['y']) + $vertices[$i]['x']) {
            $intersections++;
        }
    }
    return $intersections % 2 !== 0;
}

function isClosetoPreviousPoint($x, $y, $xp, $yp) {
    $distance = sqrt(pow($x - $xp, 2) + pow($y - $yp, 2));
    if ($distance <= 50) {
        return true;
    }
    return false;
}
// Send the response back to the client
header('Content-Type: application/json');
echo json_encode($response);

/*
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
*/

