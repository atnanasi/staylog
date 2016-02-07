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

function SetPage($PageName,$Data) {
	if (file_exists("page/{$PageName}/config.ini")) {
		
		$Config["general"]["filename"] = $Data["filename"];
		$Config["general"]["title"] = $Data["title"];
		$Config["general"]["type"] = $Data["type"];
		$Config["general"]["author"] = $Data["author"];
		$Config["general"]["date"] = $Data["date"];
		$Config["general"]["time"] = $Data["time"];
		$Config["general"]["tag"] = $Data["tag"];
		$Config["general"]["priority"] = $Data["priority"];
		write_ini_file($Config, "page/{$PageName}/config.ini");
		
		return 1;
	}else{
		return 0;
	}
}

function write_ini_file($keys,$filename) {
	if (!(file_exists($filename))) {
		touch ($filename);
	}
	$WriteData = "";
	foreach ($keys as $section => $sections) {
		$WriteData .= "[$section]\n";
		foreach ($sections as $key => $keyss) {
			$WriteData .= "{$key}=\"{$keys[$section][$key]}\"\n";
		}
		$WriteData .= "\n";
	}
	file_put_contents($filename, $WriteData);
}

function GetExtension($Type,$Table) {
	$RetData = "";
	$TableKeys = explode("\n", rtrim($Table, "\n"));
	foreach($TableKeys as $TableKey) {
		$TableData = explode(",", $TableKey);
		if ($TableData[0] === $Type) {
			$RetData = $TableData[1];
		}
	}
	return $RetData;
}

function GetPageList() {
	$files = scandir("page/");
	$RetArray = "";
	$i = 0;
	foreach($files as $file => $sutehage) {
		if ((strpos($files[$file], ".")) === false) {
			$RetArray[$i] = $files[$file];
			$i++;
		}
	}
	return $RetArray;
}

function ParseFile($TextType, $RawText) {
	include "plugin/{$TextType}/main.php";
	return $Pagetext;
}
?>
