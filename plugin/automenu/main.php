<?php
//Auto menu - Auto menu generator
//Name,Url

if ($Mode) {
	$Topmenu = "";
	$MenuTemplate = file_get_contents("theme/{$Theme}/topmenu.php");
	$MenuKeys = explode(";", rtrim(rtrim($RawTopmenu, "\n"), ";"));
	foreach($MenuKeys as $MenuKey) {
		$MenuData = explode(",", $MenuKey);
		$MenuReplace1 = str_replace("{Name}",$MenuData[0],$MenuTemplate);
		$Topmenu = $Topmenu.str_replace("{URL}",$MenuData[1],$MenuReplace1)."\n";
	}
}
?>