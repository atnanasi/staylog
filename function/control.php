<?php
//Staylog control.php-1.00
//Copyright (c) 2016 Atnanasi

$root = __DIR__;
$version = "1.00";
require_once"lib/stayfunc.php";

$config = parse_ini_file("config/staylog.ini",1);
$plugin = parse_ini_file("config/plugin.ini",1);

if (ExistsPage($config["system"]["error"])) {
	$Error = GetPage($config["system"]["error"]);
	$ErrorPage = "page/{$config["system"]["error"]}/{$Error["filename"]}";
}else{
	exit(1);
}

//URLCheck
if (isset($_GET["do"])) {
	$do = $_GET["do"];
}else{
	http_response_code(404);
	echo Error("404 NotFound",$ErrorPage,"It's an unjust URL.",$version);
	exit;
}

if (isset($_GET["q"])) {
	$FileName = $_GET["q"];
}else{
	http_response_code(404);
	echo Error("404 NotFound",$ErrorPage,"It's an unjust URL.",$version);
	exit;
}

$do();

function edit() {
	global $FileName, $ErrorPage, $version;
	//編集モード
	$host  = $_SERVER["HTTP_HOST"];
	$uri   = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
	
	//ファイル存在？
	if (!(ExistsPage($FileName))) {
		http_response_code(404);
		echo Error("404 NotFound",$ErrorPage,"The appointed file does not exist.",$version);
		exit;
	}
	
	//追加チェック
	if (isset($_POST["name"])) {
		$NewName = $_POST["name"];
	}else{
		http_response_code(404);
		echo Error("404 NotFound",$ErrorPage,"It's an unjust URL.",$version);
		exit;
	}

	if (isset($_POST["text"])) {
		$NewText = $_POST["text"];
	}else{
		http_response_code(404);
		echo Error("404 NotFound",$ErrorPage,"It's an unjust URL.",$version);
		exit;
	}

	if (isset($_POST["file"])) {
		$NewFile = $_POST["file"];
	}else{
		http_response_code(404);
		echo Error("404 NotFound",$ErrorPage,"It's an unjust URL.",$version);
		exit;
	}

	if (isset($_POST["filename"])) {
		if ($_POST["filename"] === "auto") {
			$NewFileName = time();
		}else{
			$NewFileName = $NewFile;
		}
	}else{
		http_response_code(404);
		echo Error("404 NotFound",$ErrorPage,"It's an unjust URL.",$version);
		exit;
	}
	
	if (isset($_POST["type"])) {
		$Type = $_POST["type"];
	}else{
		http_response_code(404);
		echo Error("404 NotFound",$ErrorPage,"It's an unjust URL.",$version);
		exit;
	}
	
	if (isset($_POST["priority"])) {
		$Priority = $_POST["priority"];
	}else{
		http_response_code(404);
		echo Error("404 NotFound",$ErrorPage,"It's an unjust URL.",$version);
		exit;
	}
	
	if (isset($_POST["tags"])) {
		$Tag = $_POST["tags"];
	}else{
		$Tag = "";
	}
	
	$Table = file_get_contents("config/exttable.txt");
	if (GetExtension($Type, $Table)) {
		$Extension = GetExtension($Type, $Table);
	}else{
		http_response_code(404);
		echo Error("404 NotFound",$ErrorPage,"It's an unjust URL.",$version);
		exit;
	}
	
	//設定変更
	$config = parse_ini_file("page/{$FileName}/config.ini",1);
	
	$config["general"]["filename"] = "{$FileName}.{$Extension}";
	$config["general"]["title"] = $NewName;
	$config["general"]["type"] = "markdown";
	$config["general"]["author"] = "atnanasi";
	$config["general"]["date"] = date("Y/m/d");
	$config["general"]["time"] = date("H:i:s");
	$config["general"]["type"] = $Type;
	$config["general"]["tag"] = $Tag;
	$config["general"]["priority"] = $Priority;
	
	write_ini_file($config, "page/{$FileName}/config.ini");
	
	//ファイルへ書き込み
	file_put_contents("page/{$FileName}/{$config["general"]["filename"]}", $NewText);
	
	header("Location: http://$host$uri/index.php?q={$FileName}");
}

?>
