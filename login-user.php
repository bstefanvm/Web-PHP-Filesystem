<?php

include('varpath.php');

$fUserEntry = trim($userEntry);
$fUserEntry = strval(htmlspecialchars($fUserEntry, ENT_QUOTES));
$findUser = FALSE;

$UserEN = filter_input(INPUT_POST, "UserEN");
$UserPassword = filter_input(INPUT_POST, "UserPassword");

$UserEN = trim($UserEN);
$UserPassword = trim($UserPassword);

$UserEN = htmlspecialchars($UserEN, ENT_QUOTES);
$UserPassword = htmlspecialchars($UserPassword, ENT_QUOTES);

$UserEN = strval($UserEN);
$UserPassword = strval($UserEN);

if($UserEN == NULL || $UserPassword == NULL) {
	$err_msg = "Please fill all mandatory fields.<br>";
	include("$AssetDB/dbmaria_error.php");
}
elseif(!preg_match("/(?=.*[A-Za-z])[0-9A-Za-z_-]{3,18}$/", $UserEN)) {
	$err_msg = "Username must contain at least a letter with 3-12 characters.<br>";
	include("$AssetDB/dbmaria_error.php");
}
elseif(!preg_match("/(?=.*[A-Za-z])[0-9A-Za-z!%&_-]{6,18}$/", $UserPassword)) {
	$err_msg = "Password must contain at least a letter with 6-18 characters.<br>";
	include("$AssetDB/dbmaria_error.php");
}
else {
	if($UserEN !== NULL && $UserPassword !== NULL) {
		$fileUserEntry = fopen($fUserEntry, "r");
		while(!FEOF($fileUserEntry)) {
			$lineCheck = fgets($fileUserEntry);
			$checkUserEntry = explode("|", $lineCheck);
			if(trim($checkUserEntry[0]) === $UserEN || trim($checkUserEntry[1] === $UserEN)) {
				$findUser = TRUE;
				$FEPassword = trim($checkUserEntry[2]);
				password_verify($UserPassword, $FEPassword);
				$_SESSION['LogInUserName'] = ucfirst(strtolower(trim($checkUserEntry[3]))) . " " . ucfirst(strtolower(trim($checkUserEntry[4])));
				break;
			}
		}
		fclose($fileUserEntry);
		echo $_SESSION['LogInUserName'] . "<br>";
	}
}
?>
