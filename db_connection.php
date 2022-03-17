<?php
function connect_db(){
$val = 0; 
if($val==0){
$servername = "localhost";
$username = "root";
$password = "";
 $dbname = "raad_db";}
 if($val==1){
 	$servername = "localhost";
	$username = "zsqnmfsgrp";
	$password = "MXVpU5CFtT";
 	$dbname = "zsqnmfsgrp";
 }

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
	// echo "hello";
  die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";
return $conn;
}
?>