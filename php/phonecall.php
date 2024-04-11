<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Didwegetasessionstart=session_start(['cookie_lifetime' => 3000,'name'=>'AreYouStillTrying?',]);
    if(isset($_POST['digit'])){
        $digit = $_POST['digit'];
        if (!isset($_SESSION['digitstate'])) {
            $_SESSION['digitstate'] =['0000','0000','0000','0000','0000','0000','0000','0000','0000'];
        }
        if($_SESSION['digitstate'][ceil($digit/4)-1][$digit%4-1]==0){
            $_SESSION['digitstate'][ceil($digit/4)-1][$digit%4-1]=1;
        }
        else{
            $_SESSION['digitstate'][ceil($digit/4)-1][$digit%4-1]=0;
        }
        foreach ($_SESSION['digitstate'] as $digit) {
            $test=($digit[0]*1+$digit[1]*2+$digit[2]*4+$digit[3]*8);
            if($test>8){
                $_SESSION['digitstate'] =['0000','0000','0000','0000','0000','0000','0000','0000','0000'];
            }
        }
        $response['digitstate'] = $_SESSION['digitstate'];
    }
    $number = [];
    if(isset($_POST['save']) && isset($_SESSION['digitstate'])){
        foreach ($_SESSION['digitstate'] as $digit) {
            $valuetoadd=$digit[0]*1+$digit[1]*2+$digit[2]*4+$digit[3]*8;
            $number[]=$valuetoadd;
            $phonenumber=implode('',$number);
        }
        $file=file_get_contents('validated_phonenumbers.json');
        $jsonData = json_decode(file_get_contents('./validated_phonenumbers.json'), true);
        $newkey = count($jsonData)+1;
        $jsonfile = fopen('validated_phonenumbers.json','w+');
        $jsonData[$newkey]=$phonenumber;
        $jsonData=json_encode($jsonData);
        fwrite($jsonfile, $jsonData);
        fclose($jsonfile);
        $response['saved']='You have saved the number: '.$phonenumber;
    }
    $response['status'] = 'success';
    // Send the new count back to JavaScript
    header('Content-Type: application/json');
    echo json_encode($response);
}
