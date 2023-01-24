<?php
ini_set("display_errors", "on");
include_once("./classes/connect.php");

$_server = "localhost:3307";
$_username = "root";
$_password = "";
$_database = "bincomphptest";

$connect = new connect($_server, $_username, $_password, $_database);

echo "connect:: " . $connect->connect_db();
