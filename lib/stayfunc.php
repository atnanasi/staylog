<?php
//Stayfunc - Staylog functions
//Copyright (c) 2016 Atnanasi

function Error($ErrorTitle,$PagePass,$Error,$version) {
	$host  = $_SERVER["HTTP_HOST"];
	$uri   = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
	$ErrorTemplate = file_get_contents("{$PagePass}");
	$ErrorReplace1 = str_replace("{errortitle}", $ErrorTitle, $ErrorTemplate);
	$ErrorReplace2 = str_replace("{version}", $version, $ErrorReplace1);
	$ErrorPage = str_replace("{error}", $Error, $ErrorReplace2);
	//header("Location: http://$host$uri/error.php");
	return $ErrorPage;
}

function ExistsPage($PageName) {
	if (file_exists("page/{$PageName}/config.ini")) {
		return 1;
	}else{
		return 0;
	}
}

function GetPage($PageName) {
	if (file_exists("page/{$PageName}/config.ini")) {
		$Config = parse_ini_file("page/{$PageName}/config.ini",1);
		
		$Data["filename"] = $Config["general"]["filename"];
		$Data["title"] = $Config["general"]["title"];
		$Data["type"] = $Config["general"]["type"];
		$Data["author"] = $Config["general"]["author"];
		$Data["date"] = $Config["general"]["date"];
		$Data["time"] = $Config["general"]["time"];
		$Data["tag"] = $Config["general"]["tag"];
		$Data["priority"] = $Config["general"]["priority"];
		
		return $Data;
	}else{
		return 0;
	}
}

?>
