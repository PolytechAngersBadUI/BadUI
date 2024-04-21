<?php

include 'connect_database.php';
  
  echo "Received number value: " . $_SESSION['count'];
  

  $sql = "INSERT INTO workpls (number, comment) VALUES (?, 'Did we get a new highscore ?')";
  $stmt = $conn->prepare($sql);

  $stmt->bind_param("i", $_SESSION['count']);

  if ($stmt->execute()) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $sql2 = "SELECT * FROM workpls";
  $result = $conn->query($sql2);
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      echo "id: " . $row["id"]. " - Number: " . $row["number"]. " - Comment: " . $row["comment"]. "<br>";
    }
  } else {
    echo "0 results";
  }
  $stmt->close();
  $conn->close();
