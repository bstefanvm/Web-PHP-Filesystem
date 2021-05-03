<?php
// Gallery
// Upload
$query_gallery_upload = "INSERT INTO gallery_images
												(ImageID, ImageName, ImageTitle, ImageDescription, ImageInfo, ImageUploadedDate)
												VALUES
												(:ImageID, :ImageName, :ImageTitle, :ImageDescription, :ImageInfo, :ImageUploadedDate)";
$stmt = $connMaria->prepare($query_gallery_upload);

// View
$query_gallery_view = "SELECT * FROM gallery_images ORDER BY ImageUploadedDate DESC";
$stmt0 = $connMaria0->query($query_gallery_view);

// User




?>
