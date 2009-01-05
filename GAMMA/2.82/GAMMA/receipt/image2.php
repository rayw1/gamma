<?php
//GAMMA V2.7 CERTIFIED
include(getcwd().'/../includes/common.inc');
session_start();
$group = $_SESSION["group"];
$admin = $_SESSION["admin"];
$valid = $_SESSION["validsession"];
if($valid != 1)
{
	die("INVALID SESSION");
}
if($admin < 3)
{
	die("ADMIN TOO LOW");
}
// ==============
// Configuration
// ==============
$uploaddir = "images"; // Where you want the files to upload to - Important: Make sure this folders permissions is 0777!
$allowed_ext = "jpg"; // These are the allowed extensions of the files that are uploaded
$max_size = "30000";
$max_height = "200"; // This is in pixels - Leave this field empty if you don't want to upload images
$max_width = "450"; // This is in pixels - Leave this field empty if you don't want to upload images


// Check Entension
$extension = pathinfo($_FILES['file']['name']);
$extension = $extension[extension];
$allowed_paths = explode(", ", $allowed_ext);
for($i = 0; $i < count($allowed_paths); $i++) {
	if ($allowed_paths[$i] == "$extension") {
		$ok = "1";
	}
}


// Check File Size and if errors were made
if ($ok == "1") {
	if($_FILES['file']['size'] > $max_size)
	{
		print "<b>Error: File size is too big.</b><BR>Please click back to upload a file less than 30Kb in size.<br><br>";
		exit;
	}

	// Check Height & Width
	if ($max_width && $max_height) {
		list($width, $height, $type, $w) = getimagesize($_FILES['file']['tmp_name']);
		if($width > $max_width || $height > $max_height)
		{
			print "File height and/or width are too big!";
			exit;
		}
	}

	// The Upload Part
	if(is_uploaded_file($_FILES['file']['tmp_name']))
	{
		//move_uploaded_file($_FILES['file']['tmp_name'],$uploaddir.'/'.$_FILES['file']['name']);

		//new file name exmaple for a profile image of a user
		$newfile = $group.".".$extension;

		// set target path
		$target_path = $uploaddir .'/'. basename($newfile);

		if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path))
		{
			//echo "The file ". basename( $_FILES['uploadedfile']['name']). " has been uploaded";
		}
		else
		{
			die( "There was an error uploading the file, please try again! Upload path: ".$target_path);
		}
	}
	echo( "
<script>
<!--
location=\"receipt_search.php\";
//-->
</script> 
" );
}
else
{
	//Display error on screen
	print "<b>Error: Incorrect file type or no file selected.</b><br>Please click back and upload a .JPG file.";
}
?>
