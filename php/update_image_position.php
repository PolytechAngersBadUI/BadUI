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
    ['x' => 200, 'y' => 200], #A -
    ['x' => 800, 'y' => 200], #B -
    ['x' => 800, 'y' => 600], #C -
    ['x' => 1200, 'y' => 600], #D -
    ['x' => 1200, 'y' => 400], #E -
    ['x' => 1400, 'y' => 400], #F -
    ['x' => 1400, 'y' => 200], #G -
    ['x' => 1800, 'y' => 200], #H -
    ['x' => 1800, 'y' => 400], #I -
    ['x' => 1600, 'y' => 400], #J -
    ['x' => 1600, 'y' => 800], #K -
    ['x' => 1800, 'y' => 800], #L -
    ['x' => 1800, 'y' => 1000], #M -
    ['x' => 1400, 'y' => 1000], #N -
    ['x' => 1400, 'y' => 800], #O -
    ['x' => 800, 'y' => 800], #P -
    ['x' => 800, 'y' => 1000], #Q -
    ['x' => 400, 'y' => 1000], #R -
    ['x' => 400, 'y' => 600], #S -
    ['x' => 600, 'y' => 600], #T -
    ['x' => 600, 'y' => 800], #U -
    ['x' => 500, 'y' => 800], #V -
    ['x' => 500, 'y' => 700], #W -
    ['x' => 500, 'y' => 900], #Z -
    ['x' => 700, 'y' => 900], #A1 -
    ['x' => 700, 'y' => 700], #B1 -
    ['x' => 1500, 'y' => 700], #C1 -
    ['x' => 1500, 'y' => 900], #D1 -
    ['x' => 1700, 'y' => 900], #E1 -
    ['x' => 1500, 'y' => 900], #D1 -
    ['x' => 1500, 'y' => 300], #F1 -
    ['x' => 1700, 'y' => 300], #G1 -
    ['x' => 1500, 'y' => 300], #F1 -
    ['x' => 1500, 'y' => 500], #H1 -
    ['x' => 1300, 'y' => 500], #I1 -
    ['x' => 1300, 'y' => 700], #J1 -
    ['x' => 700, 'y' => 700], #B1 -
    ['x' => 700, 'y' => 300], #K1 -
    ['x' => 200, 'y' => 300] #L1 -
];

$Startup_point_2=['x' => 250, 'y' => 250];
$Ending_point_2=['x' => 545.8, 'y' => 747.4];

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
$Ending_point_3=['x' => 550, 'y' => 750];

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
        if($x>$_SESSION['current_ending_point']['x']-25 && $x<$_SESSION['current_ending_point']['x']+25 && $y>$_SESSION['current_ending_point']['y']-25 && $y<$_SESSION['current_ending_point']['y']+25){
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
