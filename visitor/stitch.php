<?php
session_start();
if(!ISSET($_GET['go']) || !ISSET($_GET['q'])){
	// only if nothing has been passed
	header("Location: index.php");
}
$gopage = $_GET['go'].".php";
$question = $_GET['q'];
$nopage = "../logout.php";

// assuming we are living with 'Yes' and 'No' options here. *sigh*
// lets build the form
?>
<p align="center">
<form method="POST">
<p><strong><?php echo $question;?>?</strong></p>
<input type="button" name="butty" class="button" value="Yes" onClick="javascript:window.location='<?php echo $gopage;?>';return false;" />
<input type="button" name="buttn" class="button" value="No" onClick="javascript:window.location='<?php echo $nopage;?>';return false;" />
</form></p>
