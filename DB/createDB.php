<?php



require_once 'credentials.php';


// Create connection
$conn = new mysqli($serverName, $username, $password);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS $DBname";
if ($conn->query($sql) === TRUE) {
  echo "Database created successfully";
} else {
  echo "Error creating database: " . $conn->error;
}

// Create connection
$conn = new mysqli($serverName, $username, $password, $DBname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// sql to create user table
$sql = "CREATE TABLE IF NOT EXISTS Users (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
last_update INT(5),
date_of_last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
username VARCHAR(10) NOT NULL UNIQUE,
password VARCHAR(255) NOT NULL,
email VARCHAR(35) UNIQUE  DEFAULT NULL,
status INT(1) NOT NULL,
reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
email_verified TINYINT(1) DEFAULT 0
)";

if ($conn->query($sql) === TRUE) {
  echo "<br>Table Users created successfully";
} else {
  echo "<br>Error creating table: " . $conn->error;
}

// sql to create messages table
$sql = "CREATE TABLE IF NOT EXISTS Messages (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    shomrim INT(1) NOT NULL,
    nikayon INT(1) NOT NULL,
    ahzaka INT(1) NOT NULL,
    stat VARCHAR(10) NOT NULL,
    msg TEXT NOT NULL,
    expire_date DATE,
    created_by VARCHAR(25),
    update_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_by VARCHAR(25),
    create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
    random_id INT(6) NOT NULL
    )";
    
    if ($conn->query($sql) === TRUE) {
      echo "<br>Table Messages created successfully";
    } else {
      echo "<br>Error creating table: " . $conn->error;
    }



    $sql = 'CREATE TABLE IF NOT EXISTS tokens(
      id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      user_id INT(6) NOT NULL,
      token INT(6) NOT NULL,
      email_password VARCHAR(8),
      temp_value VARCHAR(35),
      verified TINYINT(1) DEFAULT 0,
      expiry_time TIMESTAMP

    )';


if ($conn->query($sql) === TRUE) {
  echo "<br>Table Tokens created successfully";
} else {
  echo "<br>Error creating table: " . $conn->error;
}
$conn->close();


?>