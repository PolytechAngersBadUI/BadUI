<?php
// Receive the x and y coordinates from the client
session_start(['cookie_lifetime' => 30000,]);
$data = json_decode(file_get_contents('php://input'), true);
$x = $data['x'];
$y = $data['y'];
if(!isset($_SESSION['level'])){
    $_SESSION['level']=1;
}

// Define the path coordinates
$path_1 = [
    ['x' => 100, 'y' => 100],
    ['x' => 800, 'y' => 100],
    ['x' => 800, 'y' => 800],
    ['x' => 100, 'y' => 800]
];
$Startup_point_1=['x' => 250, 'y' => 250];
$Ending_point_1=['x' => 700, 'y' => 700];
$path_2 = [
    ['x' => 300, 'y' => 300],
    ['x' => 700, 'y' => 300],
    ['x' => 700, 'y' => 700],
    ['x' => 300, 'y' => 700]
];
$Startup_point_2=['x' => 450, 'y' => 450];
$Ending_point_2=['x' => 600, 'y' => 600];

$current_path = $path_1;
$current_starting_point = $Startup_point_1;
$current_ending_point = $Ending_point_1;



// Check if the image is on the goal then still inside the path and if the image hasn't been draggedf too far
if(isOnGoal($x,$y,) && isClosetoPreviousPoint($x, $y, $_SESSION['xp'], $_SESSION['yp'])){
    $_SESSION['level']++;
    if($_SESSION['level']==2){
        $current_path = $path_2;
        $current_starting_point = $Startup_point_2;
        $current_ending_point = $Ending_point_2;
    }
    else{
        $_SESSION['level']=1;
        $current_path = $path_1;
        $current_starting_point = $Startup_point_1;
        $current_ending_point = $Ending_point_1;
    }
    $response = [
        'status' => 'success',
        'message' => 'Image is on the goal, CONGRATZ! You have completed the level '.$_SESSION['level'].'. Place the image on the next path.',
        'x' => $current_starting_point['x'],
        'y' => $current_starting_point['y'],
        'level'=>$_SESSION['level'],
    ];
    $_SESSION['xp']=$current_starting_point['x'];
    $_SESSION['yp']=$current_starting_point['y'];
}
else if (isInsidePath($x, $y, $current_path) && isClosetoPreviousPoint($x, $y, $_SESSION['xp'], $_SESSION['yp'])) {
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
    $response['x'] = $current_starting_point['x'];
    $response['y'] = $current_starting_point['y'];
    $_SESSION['xp'] =  $current_starting_point['x'];
    $_SESSION['yp'] = $current_starting_point['y'];
}else{
    $response['status'] = 'out';
    $response['message'] = 'Image is not inside the path';
    $response['x_out'] = $x;
    $response['y_out'] = $y;
    $response['x'] = $current_starting_point['x'];
    $response['y'] = $current_starting_point['y'];
    $_SESSION['xp'] =  $current_starting_point['x'];
    $_SESSION['yp'] = $current_starting_point['y'];
}

/**
 * Check if a point is inside a polygon defined by its vertices.
 * @param int $x The x-coordinate of the point
 * @param int $y The y-coordinate of the point
 * @param array $vertices The vertices of the polygon
 * @return bool True if the point is inside the polygon, false otherwise
 */
function isOnGoal($x, $y) {
    global $current_path;
    global $current_starting_point;
    global $current_ending_point;
        if($x>$current_ending_point['x']-50 && $x<$current_ending_point['x']+50 && $y>$current_ending_point['y']-50 && $y<$current_ending_point['y']+50){
            return true;
        }else{
            return false;
        }}
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

