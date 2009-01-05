<?php
//GAMMA V2.7 CERTIFIED
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
?>
<form action="image2.php" method="post" ENCTYPE="multipart/form-data" ID="submitionform">
<h1>Receipt Image Upload</h1>

File:<input type="file" name="file" size="30"><br>
Uploads limited to:<br>
No larger than 30k<br>
.JPG FILES ONLY<br>
max height is 200px<br>
max width is 450px<br>
<input type="submit" ID="submitBtn" value="Click to Upload" onclick="document.getElementById('submitBtn').disabled=true;document.getElementById('submitBtn').value='Please Wait...';submit();"></td>

</form>
