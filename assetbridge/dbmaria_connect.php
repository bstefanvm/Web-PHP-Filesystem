<?php

// PDO
DEFINE ('DB_USER', 'webadm');
DEFINE ('DB_PASSWORD', 'webadmpwd');
$pdoDSN = 'mysql:host=localhost;port=3306;dbname=WebDB';

try {
	$connMaria = new PDO($pdoDSN, DB_USER, DB_PASSWORD);
	$connMaria->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e){
	$err_msg = $e->getMessage();
	include('dbmaria_error.php');
	exit();
}

// PDO - MySQL
$dbHost     = "localhost";
$dbUsername = "webadm";
$dbPassword = "webadmpwd";
$dbName     = "WebDB";

$connMaria0 = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
if ($connMaria0->connect_error) {
	die("Connection failed: " . $connMaria0->connect_error);
	exit();
}

echo "Database Connection included!<br>";

?>
