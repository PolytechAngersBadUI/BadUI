<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  include 'connect_database.php'; 

  
  $number = $_POST['number'];
  

  echo "Received number value: " . $number;

 
  $sql = "INSERT INTO workpls (number, comment) VALUES (?, 'Here is a comment I want to see')";
  $stmt = $conn->prepare($sql);

  // Bind param
  $stmt->bind_param("i", $number);

 
  if ($stmt->execute()) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  
  $sql2 = "SELECT * FROM workpls";
  $result = $conn->query($sql2);
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      echo "id: " . $row["id"]. " - Number: " . $row["number"]. " - Comment: " . $row["comment"]. "<br>";
    }
  } else {
    echo "0 results";
  }
  
  $stmt->close();
  $conn->close();
}