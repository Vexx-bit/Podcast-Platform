<?php
$servername = "localhost";
$server_username = "root";
$password = "";
$db_name = "real_estate";
$con = new mysqli($servername, $server_username, $password, $db_name);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
