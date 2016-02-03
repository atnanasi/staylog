<?php
//Staylog system.php-1.00
//Copyright (c) 2016 Atnanasi

$root = __DIR__;
$version = "3.00";
require_once"../lib/acwiki/core.php";
$config = parse_ini_file("../config/staylog.ini",1);

$host  = $_SERVER["HTTP_HOST"];
$uri   = rtrim(dirname($_SERVER["PHP_SELF"]), "/system/\\");

switch ($_GET["mode"]) {
	case "view":
		$Nexturl = $_GET["q"];
		header("Location: http://$host$uri/index.php?q=$Nexturl");
		break;
	case "edit":
		$Editname = $_POST["name"];
		$Edittext = $_POST["text"];
		$Editfile = "../".$config["system"]["pagepass"]."/".$Editname.".md";
		if (file_exists($Editfile)) {
			$file = fopen($Editfile,"w");
			fwrite($file,$Edittext);
			fclose($file);
		}
		header("Location: http://$host$uri/system/system.php?mode=view&q=$Editname");
		break;
	case "new":
		$Newname = $_POST["name"];
		$Newtext = $_POST["text"];
		$Newfile = "../".$config["system"]["pagepass"]."/".$Newname.".md";
		if (!(file_exists($Newfile))) {
			touch($Newfile);
			$file = fopen($Newfile,"w");
			fwrite($file,$Newtext);
			fclose($file);
		}
		header("Location: http://$host$uri/system/system.php?mode=view&q=$Newname");
		break;
	default:
		//Go to index
		header("Location: http://$host$uri/index.php");
		break;
}
exit;
?>
