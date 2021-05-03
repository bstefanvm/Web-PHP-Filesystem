<?php
require_once('varpath.php');
require_once("$AssetDB/dbmaria_connect.php");
require_once("$AssetResource/rsc-db.php");


if($stmt0->num_rows > 0){
	while($row = $stmt0->fetch_assoc()) {
		$imageURL = $gfImageExistence . $row["ImageName"];
		$imageURL = trim($imageURL);
		$imageURL = htmlspecialchars($imageURL, ENT_QUOTES);
		$imageURL = strval($imageURL);
		echo $imageURL . "<br>";
?>
	<div class="gallery">
		<img src="<?php echo $imageURL; ?>" alt="" height="250px" width="250px"/>
		<p><?php echo $row["ImageTitle"]; ?></p>
		<p><?php echo $row["ImageDescription"]; ?></p>
		<p><?php echo $row["ImageInfo"]; ?></p>
		<p><?php echo $row["ImageUploadedDate"]; ?></p>
	</div>
<?php
	}
}
else {
?>
		<p>No image(s) found...</p>
<?php
}
?>
