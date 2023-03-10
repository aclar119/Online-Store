<?php
  $db_host = 'localhost';
  $db_user = 'root';
  $db_password = 'root';
  $db_db = 'onlinestore';
 
  $conn = @new mysqli(
    $db_host,
    $db_user,
    $db_password,
    $db_db
  );

  // Check if Users table exists
  $result = $conn->query("SHOW TABLES LIKE 'Users'");
  if ($result->num_rows == 0) {
    // Create Users table
    $sql = "CREATE TABLE Users (
      ID INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
      usersUname VARCHAR(128) NOT NULL,
      usersEmail VARCHAR(80) NOT NULL,
      UsersPassword VARCHAR(255) NOT NULL
    )";
  }
?>