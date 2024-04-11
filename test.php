<?php
    $digit = 2;
    //$Didwegetasessionstart=session_start(['cookie_lifetime' => 3000,'name'=>'AreYouStillTrying?',]);
    $digitstate =['0000','0000','0000','0000','0000','0000','0000','0000','0000'];
    if($digitstate[ceil($digit/4)-1][$digit%4-1]==0){
        $digitstate[ceil($digit/4)-1][$digit%4-1]=1;
    }
    else{
        $digitstate[ceil($digit/4)-1][$digit%4-1]=0;
    }
    $numberresponse['digitstate'] = $digitstate;
    // Send the new count back to JavaScript
    header('Content-Type: application/json');
    echo json_encode($numberresponse);

