<?php
require_once('varpath.php');

// Database
$imageP = $_FILES['ImgGallery'];
$imagePz = basename($imageP["name"]);
$imgExt = pathinfo($imagePz, PATHINFO_EXTENSION);
$allowedExt = array('jpg','png','jpeg');
$allowedSize = $_FILES['ImgGallery']['size'] <= 6291456;

$imgTitle = filter_input(INPUT_POST, "ImgTitle");
$imgInf = filter_input(INPUT_POST, "ImgInfo");
$ImgDesc = filter_input(INPUT_POST, "ImgDescription");
$ImgUplD = date('Y-m-d H:i:s');

$imgInf = trim($imgInf);
$imgTitle = trim($imgTitle);
$imgExt = trim($imgExt);
$imgInf = strtolower($imgInf);
$ImgInf = htmlspecialchars($imgInf, ENT_QUOTES);
$imgTitle = htmlspecialchars($imgTitle, ENT_QUOTES);
$ImgTitle = ucfirst(strtolower($imgTitle));
$ManipulationDate = date("m-d-Y");
$ManipulationDate = trim(htmlspecialchars($ManipulationDate, ENT_QUOTES));

$ExistenceSource = $_FILES["ImgGallery"]["tmp_name"];
$ExistenceName = $ManipulationDate . "_" . $ImgTitle . "-" . $ImgInf . "." . $imgExt;
$ExistenceName = trim($ExistenceName);
$ExistenceName = htmlspecialchars($ExistenceName, ENT_QUOTES);

$ExistenceFinale = $gImageExistence . $ExistenceName;
$ExistenceFinale = trim(htmlspecialchars($ExistenceFinale, ENT_QUOTES));

// File
$fEntryImage = trim($gImageEntry);
$fEntryImage = strval(htmlspecialchars($fEntryImage, ENT_QUOTES));
$separator = "|";
$EntryTextImage = $ManipulationDate . $separator . $ImgTitle . $separator . $ImgInf;
$EntryTextImage = strval($EntryTextImage);
$EntryTextImage = trim(htmlspecialchars($EntryTextImage, ENT_QUOTES));

if(!is_uploaded_file($ExistenceSource) && $allowedSize == NULL && in_array($imgExt, $allowedExt) ||
	$ImgTitle == NULL || $ImgDesc == NULL || $ImgInf == NULL || $ImgUplD == NULL) {
	$err_msg = "Upload error! Either you did'nt select an image, image size more than 6MB, or you forget to complete the form.<br>";
	include("$AssetDB/dbmaria_error.php");
}
elseif(!preg_match("/^[a-zA-Z0-9]{3,60}+$/", $ImgTitle)) {
	$err_msg = "Image title is incorrect.<br>";
	include("$AssetDB/dbmaria_error.php");
}
elseif(!filter_var($ImgInf, FILTER_VALIDATE_EMAIL)) {
	$err_msg = "Email is incorrect.<br>";
	include("$AssetDB/dbmaria_error.php");
}
elseif(file_exists($ExistenceFinale)) {
	$err_msg = "Your image title is already exist!";
	include("$AssetDB/dbmaria_error.php");
}
elseif(str_contains(file_get_contents($fEntryImage), $ImgTitle)) {
	$err_msg = "Your image title is already exist!";
	include("$AssetDB/dbmaria_error.php");
}
else {
	if(move_uploaded_file($ExistenceSource, $ExistenceFinale)) {
		require_once("$AssetDB/dbmaria_connect.php");
		require_once("$AssetResource/rsc-db.php");

		$stmt->bindValue(':ImageID', NULL, PDO::PARAM_INT);
		$stmt->bindValue(':ImageName', $ExistenceName);
		$stmt->bindValue(':ImageTitle', $ImgTitle);
		$stmt->bindValue(':ImageDescription', $ImgDesc);
		$stmt->bindValue(':ImageInfo', $ImgInf);
		$stmt->bindValue(':ImageUploadedDate', $ImgUplD);
		$execute_success = $stmt->execute();
		$stmt->closeCursor();

		if(!$execute_success) {
			print_r($stmt->errorInfo()[2]);
		}
		else {
			file_put_contents($fEntryImage, $EntryTextImage . PHP_EOL, FILE_APPEND);
			echo "You just uploaded an image<br>";
		}
	}
}
?>
