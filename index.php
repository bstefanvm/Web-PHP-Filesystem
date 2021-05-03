<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/index.css" type="text/css">
	<title>Debdev.com | Home</title>
</head>
<body>
	<div class="ImageForm">
		<h1>Image upload form</h1>
		<form enctype="multipart/form-data" action="add-image.php" method="POST">
			<label>Select Image:</label>
			<input type="file" name="ImgGallery">
			<br>
			<label>Add Title:</label>
			<input type="text" name="ImgTitle">
			<br>
			<label>Add Description:</label>
			<input type="text" name="ImgDescription">
			<br>
			<label>Add E-Mail:</label>
			<input type="text" name="ImgInfo">
			<br>
			<input type="submit" name="Submit_Image" value="Submit">
			<br>
		</form>
	</div>
	<div class="SignUpForm">
		<h1>Sign Up</h1>
		<form action="add-user.php" method="POST">
			<label>Email:</label>
			<input type="text" name="UserMail"><br>
			<label>Username:</label>
			<input type="text" name="UserName"><br>
			<label>Password:</label>
			<input type="password" name="UserPassword"><br>
			<label>Verify your Password:</label>
			<input type="password" name="UserPasswordAuth"><br>
			<label>First Name:</label>
			<input type="text" name="UserFirstName"><br>
			<label>Last Name:</label>
			<input type="text" name="UserLastName"><br>
			<input type="submit" name="Submit_SignUp" value="Submit"><br>
			<label>
		</form>
	</div>
	<?php
	include_once('view-image.php');
	?>
</body>
</html>
