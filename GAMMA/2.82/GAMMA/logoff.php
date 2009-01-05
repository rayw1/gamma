<?php
//GAMMA V2.7 CERTIFIED
setcookie("username", "", time()-3600);
setcookie("password", "", time()-3600);
setcookie("group", "", time()-3600);
session_start();
session_destroy();

echo( "
<script>
location=\"login.php\";
</script> 
");

?>
