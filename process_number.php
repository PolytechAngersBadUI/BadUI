<?php

$number = $_GET['number'];
echo "Received number value: " . $number;




if($_SERVER['REQUEST_METHOD'] == 'POST'){
  //include 'connect_database.php';
  $number = $_GET['number'];
  echo "Received number value: " . $number;
  //$sql = "INSERT INTO process_number (value) VALUES ('$number')";
  //if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
//} else {
  //echo "Error: " . $sql . "<br>" . $conn->error;
//}
  //$conn->close();
}
?>