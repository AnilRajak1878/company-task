<?php
session_start();

$conn = mysqli_connect("localhost","root","","car_rental");

if ($conn -> connect_errno) {
    echo "Failed to connect to MySQL: " . $conn -> connect_error;
    exit();
}