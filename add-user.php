<?php

require_once('varpath.php');

$fUserEntry = trim($userEntry);
$fUserEntry = strval(htmlspecialchars($fUserEntry, ENT_QUOTES));
$separator = "|";

$UserMail = filter_input(INPUT_POST, "UserMail");
$UserName = filter_input(INPUT_POST, "UserName");
$UserPassword = filter_input(INPUT_POST, "UserPassword");
$UserPasswordAuth = filter_input(INPUT_POST, "UserPasswordAuth");
$RUserFN = filter_input(INPUT_POST, "UserFirstName");
$RUserLN = filter_input(INPUT_POST, "UserLastName");
$CreatedDate = date('Y-m-d.H:i:s');

$UserMail = trim(htmlspecialchars($UserMail, ENT_QUOTES));
$UserName = trim(htmlspecialchars($UserName, ENT_QUOTES));
$UserPassword = trim(htmlspecialchars($UserPassword, ENT_QUOTES));
$UserPasswordAuth = trim(htmlspecialchars($UserPasswordAuth, ENT_QUOTES));
$RUserFN =  trim(htmlspecialchars($RUserFN, ENT_QUOTES));
$RUserLN = trim(htmlspecialchars($RUserLN, ENT_QUOTES));
$CreatedDate = trim(htmlspecialchars($CreatedDate, ENT_QUOTES));

$RUserFN = ucfirst(strtolower($RUserFN));
$RUserLN = ucfirst(strtolower($RUserLN));

$UserMail = strval($UserMail);
$UserName = strval($UserName);
$UserPassword = strval($UserPassword);
$UserPasswordAuth = strval($UserPasswordAuth);
$RUserFN = strval($RUserFN);
$RUserLN = strval($RUserLN);
$CreatedDate = strval($CreatedDate);

// File - Check user
$findUserOffset = 0;
$findUser = FALSE;

if($UserMail == NULL || $UserName == NULL || $UserPassword == NULL || $UserPasswordAuth == NULL || $UserName == NULL ||
	$RUserFN == NULL || $RUserLN == NULL || $CreatedDate == NULL) {
	$err_msg = "Please fill all mandatory fields.<br>";
	include("$AssetDB/dbmaria_error.php");
}
elseif(!preg_match("/(?=.*[A-Za-z])[0-9A-Za-z_-]{3,18}$/", $UserName)) {
	$err_msg = "Username must contain at least a letter with 3-12 characters.<br>";
	include("$AssetDB/dbmaria_error.php");
}
elseif(!preg_match("/(?=.*[A-Za-z])[0-9A-Za-z!%&_-]{6,18}$/", $UserPassword)) {
	$err_msg = "Password must contain at least a letter with 6-18 characters.<br>";
	include("$AssetDB/dbmaria_error.php");
}
elseif(!preg_match("/[a-zA-Z]{3,18}$/", $RUserFN)) {
	$err_msg = "First Name is not valid.<br>";
	include("$AssetDB/dbmaria_error.php");
}
elseif(!preg_match("/[a-zA-Z]{3,18}$/", $RUserLN)) {
	$err_msg = "Last Name is not valid.<br>";
	include("$AssetDB/dbmaria_error.php");
}
elseif(!filter_var($UserMail, FILTER_VALIDATE_EMAIL)) {
	$err_msg = "Email is not valid.<br>";
	include("$AssetDB/dbmaria_error.php");
}
elseif($UserPassword !== $UserPasswordAuth) {
	$err_msg = "Password did not match!";
	include("$AssetDB/dbmaria_error.php");
}
else {
	if($UserMail !== NULL && $UserName !== NULL && $UserPassword !== NULL) {
		$fileUserEntry = fopen($fUserEntry, "r");
		while(!FEOF($fileUserEntry))	{
			$lineCheck = fgets($fileUserEntry);
			$checkUserEntry = explode("|", $lineCheck);
			if(trim($checkUserEntry[0]) === $UserMail || trim($checkUserEntry[1] === $UserName)) {
				$findUser = TRUE;
				break;
			}
		}
		fclose($fileUserEntry);
		if($findUser) {
			$err_msg = "Username or E-Mail is already existed!";
			include("$AssetDB/dbmaria_error.php");
		}
		else {
			$options = ['cost' => 13];
			$UserPassword = password_hash($UserPassword, PASSWORD_BCRYPT, $options);
			$UserPassword = trim(htmlspecialchars($UserPassword, ENT_QUOTES));
			$UserPassword = strval($UserPassword);

			// File - Create user
			$EntryTextUser = $UserMail . $separator . $UserName . $separator . $UserPassword . $separator . $RUserFN . $separator . $RUserLN . $separator . $CreatedDate;
			$EntryTextUser = trim(htmlspecialchars($EntryTextUser, ENT_QUOTES));
			$EntryTextUser = strval($EntryTextUser);

			file_put_contents($fUserEntry, $EntryTextUser . PHP_EOL, FILE_APPEND);
			echo "Your account has been created!";
		}
	}
}
?>
