<?php
// Receive the x and y coordinates from the client
session_start(['cookie_lifetime' => 40000,]);
$data = json_decode(file_get_contents('php://input'), true);
$x = $data['x'];
$y = $data['y'];


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
    ['x' => 200, 'y' => 200],
    ['x' => 700, 'y' => 300],
    ['x' => 700, 'y' => 700],
    ['x' => 300, 'y' => 700]
];

$Startup_point_2=['x' => 450, 'y' => 450];
$Ending_point_2=['x' => 600, 'y' => 600];

$path_3 = [
    ['x' => 300, 'y' => 300],
    ['x' => 300, 'y' => 500],
    ['x' => 550, 'y' => 500],
    ['x' => 550, 'y' => 650],
    ['x' => 800, 'y' => 650],
    ['x' => 800, 'y' => 800],
    ['x' => 500, 'y' => 800],
    ['x' => 500, 'y' => 950],
    ['x' => 900, 'y' => 950],
    ['x' => 900, 'y' => 550],
    ['x' => 700, 'y' => 550],
    ['x' => 700, 'y' => 300]
];
$Startup_point_3=['x' => 400, 'y' => 400];
$Ending_point_3=['x' => 575, 'y' => 825];

if(!isset($_SESSION['level'])){
    $_SESSION['level']=1;
    $_SESSION['current_path'] = $path_1;
    $_SESSION['current_starting_point'] = $Startup_point_1;
    $_SESSION['current_ending_point'] = $Ending_point_1;
    $_SESSION['init']=1;
}


if($_SESSION['init']==1){
    $_SESSION['init']=0;
    $response = [
        'status' => 'init',
        'message' => 'You will start the level '.$_SESSION['level'].'. Placing the image on the starting point. You have to get to x= '.$_SESSION['current_ending_point']['x'].' and y= '.$_SESSION['current_ending_point']['y'].'',
        'x' => $_SESSION['current_starting_point']['x'],
        'y' => $_SESSION['current_starting_point']['y'],
        'level'=>$_SESSION['level'],
        'endingcoordx' => $_SESSION['current_ending_point']['x'],
        'endingcoordy' => $_SESSION['current_ending_point']['y'],
        'path' => $path_1
    ];
    $_SESSION['xp']=$_SESSION['current_ending_point']['x'];
    $_SESSION['yp']=$_SESSION['current_ending_point']['y'];
}
// Check if the image is on the goal then still inside the path and if the image hasn't been dragged too far from the path of the current level
else if(isOnGoal($x,$y) && isClosetoPreviousPoint($x, $y, $_SESSION['xp'], $_SESSION['yp'])){
    if($_SESSION['level']==1){
        $_SESSION['level']=2;
        $_SESSION['current_path'] = $path_2;
        $_SESSION['current_starting_point'] = $Startup_point_2;
        $_SESSION['current_ending_point'] = $Ending_point_2;
    }
    elseif($_SESSION['level']==2){
        $_SESSION['level']=3;
        $_SESSION['current_path'] = $path_3;
        $_SESSION['current_starting_point'] = $Startup_point_3;
        $_SESSION['current_ending_point'] = $Ending_point_3;
    }
    else{
        $_SESSION['level']=1;
        $_SESSION['current_path'] = $path_1;
        $_SESSION['current_starting_point'] = $Startup_point_1;
        $_SESSION['current_ending_point'] = $Ending_point_1;
    }
    $response = [
        'status' => 'success',
        'message' => 'Image is on the goal, CONGRATZ! You have completed the level. You will start the level '.$_SESSION['level'].'. Placing the image on the next path.',
        'x' => $_SESSION['current_starting_point']['x'],
        'y' => $_SESSION['current_starting_point']['y'],
        'level'=>$_SESSION['level'],
        'path' => $_SESSION['current_path']
    ];
    $_SESSION['xp']=$_SESSION['current_starting_point']['x'];
    $_SESSION['yp']=$_SESSION['current_starting_point']['y'];
}
else if (isInsidePath($x, $y) && isClosetoPreviousPoint($x, $y, $_SESSION['xp'], $_SESSION['yp'])) {
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
    $response['x'] = $_SESSION['current_starting_point']['x'];
    $response['y'] = $_SESSION['current_starting_point']['y'];
    $_SESSION['xp'] =  $_SESSION['current_starting_point']['x'];
    $_SESSION['yp'] = $_SESSION['current_starting_point']['y'];
}else{
    $response['status'] = 'out';
    $response['message'] = 'Image is not inside the path';
    $response['x_out'] = $x;
    $response['y_out'] = $y;
    $response['x'] = $_SESSION['current_starting_point']['x'];
    $response['y'] = $_SESSION['current_starting_point']['y'];
    $_SESSION['xp'] =  $_SESSION['current_starting_point']['x'];
    $_SESSION['yp'] = $_SESSION['current_starting_point']['y'];
}
$response['endingcoordx'] = $_SESSION['current_ending_point']['x'];
$response['endingcoordy'] = $_SESSION['current_ending_point']['y'];

function isOnGoal($x, $y) {
        if($x>$_SESSION['current_ending_point']['x']-50 && $x<$_SESSION['current_ending_point']['x']+50 && $y>$_SESSION['current_ending_point']['y']-50 && $y<$_SESSION['current_ending_point']['y']+50){
            return true;
        }else{
            return false;
        }}
function isInsidePath($x, $y) {
    $vertices = $_SESSION['current_path'];
    $intersections = 0;
    $verticesCount = count($vertices);

    for ($i = 0; $i < $verticesCount; $i++) {
        $j = ($i + 1) % $verticesCount;
        if (($vertices[$i]['y'] > $y) !== ($vertices[$j]['y'] > $y) &&
            $x < ($vertices[$j]['x'] - $vertices[$i]['x']) * ($y - $vertices[$i]['y']) / 
            ($vertices[$j]['y'] - $vertices[$i]['y']) + $vertices[$i]['x']) {
            $intersections++;
        }
    }
    return $intersections % 2 !== 0;
}

function isClosetoPreviousPoint($x, $y, $xp, $yp) {
    $distance = sqrt(pow($x - $xp, 2) + pow($y - $yp, 2));
    if ($distance <= 25) {
        return true;
    }
    return false;
}
// Send the response back to the client
header('Content-Type: application/json');
echo json_encode($response);
