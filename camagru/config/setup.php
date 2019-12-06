<?php
require 'database.php';
$con = "USE camagru ";
try {
    $con = new PDO("mysql:host=$DB_DSN", $DB_USER, $DB_PASSWORD);
    // set the PDO error mode to exception
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE DATABASE IF NOT EXISTS camagru";
    // use exec() because no results are returned
    $con->exec($sql);
//echo "Database created successfully<br>";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }
$con = null;
try {
    $con = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
    // set the PDO error mode to exception
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // sql to create table
    $sql = "CREATE TABLE IF NOT EXISTS users (
    `user_id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(255) NOT NULL,
    email VARCHAR(255),
    Passwrd VARCHAR(255) NOT NULL,
    token VARCHAR(32) NOT NULL,
    active BOOLEAN NOT NULL,
    notifications BOOLEAN NOT NULL
    -- reg_date TIMESTAMP
    )";
    // use exec() because no results are returned
    $con->exec($sql);
   // echo "Table users created successfully<br>";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }
$con = null;
try {
    $con = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
    // set the PDO error mode to exception
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // sql to create table
    $sql = "CREATE TABLE IF NOT EXISTS images (
    `image_id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    `image`VARCHAR(200) NOT NULL,
    `user` VARCHAR(255) NOT NULL,
	`text` TEXT(30) NULL
    )";
    // use exec() because no results are returned
    $con->exec($sql);
   // echo "Table images created successfully<br>";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }
$con = null;
try {
    $con = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
    // set the PDO error mode to exception
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // sql to create table
    $sql = "CREATE TABLE IF NOT EXISTS likes (
    `like_id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    `image_id` INT(11),
    `user` varchar(200),
    `image` INT(11)
       )";
    // use exec() because no results are returned
    $con->exec($sql);
    //echo "Table likes created successfully<br>";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }
$con = null;
try {
    $con = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
    // set the PDO error mode to exception
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // sql to create table
    $sql = "CREATE TABLE IF NOT EXISTS comments (
    `comment_id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    `Username` VARCHAR(255) NOT NULL,
    `comment` TEXT NOT NULL,
    `image_id` INT(255) NOT NULL,
    `date_added` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL	
       )";
    // use exec() because no results are returned
    $con->exec($sql);
   // echo "Table comments created successfully";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }
$con = null;
?>
