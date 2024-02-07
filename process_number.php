<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  include 'connect_database.php'; // Assuming this file contains the database connection code

  // Access the value sent from the JavaScript request
  $number = $_POST['number'];
  
  // Echo the received number value (for debugging purposes)
  echo "Received number value: " . $number;

  // Prepare the SQL statement with a placeholder for the value
  $sql = "INSERT INTO workpls (number, comment) VALUES (?, 'Here is a comment I want to see')";
  
  // Prepare sql statement
  $stmt = $conn->prepare($sql);

  // Bind param
  $stmt->bind_param("i", $number); // Assuming 'number' is an integer. Use "s" for string, "d" for double, etc.

  // Execute statement and check if error
  if ($stmt->execute()) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  //Close statement & database conn
  $stmt->close();
  $conn->close();
}