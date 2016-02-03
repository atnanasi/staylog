<?php
//Acwiki core library
function error($ErrorTitle,$PagePass,$Error,$version) {
	$host  = $_SERVER["HTTP_HOST"];
	$uri   = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
	$ErrorTemplate = file_get_contents($PagePass."/error.md");
	$ErrorReplace1 = str_replace("{errortitle}", $ErrorTitle, $ErrorTemplate);
	$ErrorReplace2 = str_replace("{version}", $version, $ErrorReplace1);
	$ErrorPage = str_replace("{error}", $Error, $ErrorReplace2);
	//header("Location: http://$host$uri/error.php");
	return $ErrorPage;
}
?>
