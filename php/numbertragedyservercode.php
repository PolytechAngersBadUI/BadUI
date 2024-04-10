<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $operation = $_POST['operation'];

    if($operation!=4 and $operation!=5){
        $Didwegetasessionstart=session_start(['cookie_lifetime' => 30,'name'=>'YouShouldn\'tbelookinghere',]);
        if (!isset($_SESSION['count'])) {
            $_SESSION['count'] = 0;
        }
    }
    switch ($operation) {
        case 4:
            $numberresponse['difficultymessage']='Really ?... Do you really think it exists here?';
        break;
        case 5:
            $numberresponse['difficultymessage']='Why would you waste your time on that difficulty?';
        break;
        case 6:
            $numberresponse['difficultymessage']='So you have chosen a difficulty, you should not be reading that, you do not have the time, you should pump up that number instead!';
            $_SESSION['difficulty_chosen']=true;
        break;
        case 1:
            $_SESSION['count']--;
        break;
        case 2:
            $_SESSION['count']++;
        break;
        case 3:
            $numberresponse['validatenumber']='You got up to \''.$_SESSION['count'].'\' I\'m sure you can do better.';
            $file=file_get_contents('validated_numbers.json');
            $jsonData = json_decode(file_get_contents('./validated_numbers.json'), true);
            $newkey = count($jsonData)+1;
            $jsonfile = fopen('validated_numbers.json','w+');
            $jsonData[$newkey]=$_SESSION['count'];
            $jsonData=json_encode($jsonData);
            fwrite($jsonfile, $jsonData);
            fclose($jsonfile);
        break;
        default:
            $numberresponse['error']= 'Invalid operation. Please try again.';
        break;
    }
    if($operation!=4 and $operation!=5 and $operation!=6){
        $numberresponse['number']= $_SESSION['count'];
    }
    

    // Send the new count back to JavaScript
    header('Content-Type: application/json');
    echo json_encode($numberresponse);
}
