<?php

include 'connect_database.php'; // Contains connection to database
  
  // Echo value received
  echo "Received number value: " . $_SESSION['count'];
  

  // Prepare the SQL statement with a placeholder instead of value
  $sql = "INSERT INTO workpls (number, comment) VALUES (?, 'Did we get a new highscore ?')";
  $stmt = $conn->prepare($sql);

  // Bind param
  $stmt->bind_param("i", $_SESSION['count']);

  // Execute statement and check if error
  if ($stmt->execute()) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  //Test get all data from said table and echo it
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
  //Close statement & database conn
  $stmt->close();
  $conn->close();
