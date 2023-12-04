<?php
$db_name = "note_app";
$host = "localhost";
$pass = "";
$user = "root";



$conn = mysqli_connect($host, $user, $pass, $db_name);
if ($conn->connect_error) {



    die('Connection Failed:' . $conn->connect_error);
}
