<?php
function backup()
{
	$twoDaysAgo = mktime(0,0,0,date("m"),date("d")-2,date("Y"));
	$dirpath = "phpBackup/backups/";
	if(!file_exists("phpBackup/backups/"))
	{
		mkdir($dirpath);
	}
	$dh = opendir($dirpath);
	while (false !== ($file = readdir($dh)))
	{
		if (!is_dir("$dirpath/$file"))
		{
			$last_modified = filemtime("$dirpath/$file");
			if($twoDaysAgo >= $last_modified)
			{
				unlink("$dirpath/$file");
			}
		}
	}
	closedir($dh);
	
	$dbhost = "";
	$dbuser = "";
	$dbpass = "";
	$dbname = "";

	$backupFile = "phpBackup/backups/".$dbname . date("Y-m-d-H-i-s") . '.gz';
	$command = "mysqldump -h$dbhost -u$dbuser -p$dbpass $dbname | gzip > $backupFile";
	system($command);

	require("class.phpmailer.php");

	$mail = new PHPMailer();

	$mail->IsSMTP();                                   // send via SMTP
	$mail->Host     = "localhost"; // SMTP servers
	$mail->SMTPAuth = false;     // turn on SMTP authentication
	$mail->Username = "";  // SMTP username
	$mail->Password = ""; // SMTP password

	$mail->From     = "user@host.com";
	$mail->FromName = "DisplayName";
	$mail->AddAddress("user@host.com","DisplayName");
	$mail->AddReplyTo("user@host.com","DisplayName");

	$mail->WordWrap = 50;                              // set word wrap
	$mail->AddAttachment($backupFile);      // attachment
	$mail->IsHTML(true);                               // send as HTML

	$mail->Subject  =  "MySQL Backup from GAMMA";
	$mail->Body     =  "Full MySQL Dump";
	$mail->AltBody  =  "Full MySQL Dump";

	if(!$mail->Send())
	{
		echo "Message was not sent <p>";
		echo "Mailer Error: " . $mail->ErrorInfo;
		exit;
	}
	echo "<center>Done</center>";
}
?>
