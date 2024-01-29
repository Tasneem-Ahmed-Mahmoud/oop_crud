<?php
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
// drop database 
$sql = "DROP DATABASE IF EXISTS `crud` ";
mysqli_query($conn, $sql);
// create database 
$sql = "CREATE DATABASE `crud`";
mysqli_query($conn, $sql);
// connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    die("connection failed:" . mysqli_connect_error());
}

// create user tables
$sql = "CREATE TABLE IF NOT EXISTS  `products` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `price` DECIMAL NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `url` VARCHAR(255) NOT NULL
)";
mysqli_query($conn, $sql);