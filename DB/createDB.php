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
username VARCHAR(10) NOT NULL UNIQUE,
password VARCHAR(255) NOT NULL,
email VARCHAR(30) NOT NULL UNIQUE,
status INT(1) NOT NULL,
reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
  echo "Table Users created successfully";
} else {
  echo "Error creating table: " . $conn->error;
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
    update_date DATE,
    updated_by VARCHAR(25),
    create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($sql) === TRUE) {
      echo "Table Messages created successfully";
    } else {
      echo "Error creating table: " . $conn->error;
    }


$conn->close();


?>