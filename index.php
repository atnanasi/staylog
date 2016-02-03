<?php
//Staylog index.php-1.00
//Copyright (c) 2016 Atnanasi

$root = __DIR__;
$version = "1.00";
$query  ;
require_once"lib/acwiki/core.php";

$config = parse_ini_file("config/staylog.ini",1);
$plugin = parse_ini_file("config/plugin.ini",1);

if (isset($_GET["q"])) {
	$LoadPage = htmlspecialchars($_GET["q"]);
}else{
	$LoadPage = "index";
}
if (isset($_GET["mode"]) == 0) {
	$Mode = "view";
}else{
	$Mode = htmlspecialchars($_GET["mode"]);
	$TextType = "special";
}

//Error check

if (strstr($Mode,"..")) {
	http_response_code(404);
	echo error("404 NotFound",$config["system"]["pagepass"],"It's an unjust URL.",$version);
	exit;
}
if (!(file_exists("system/{$Mode}.php"))) {
	http_response_code(404);
	echo error("404 NotFound",$config["system"]["pagepass"],"The appointed mode does not exist.",$version);
	exit;
}

if ($Mode == "view") {
	if (strstr($LoadPage,"..")) {
		http_response_code(404);
		echo error("404 NotFound",$config["system"]["pagepass"],"It's an unjust URL.",$version);
		exit;
	}elseif (file_exists("{$config["system"]["pagepass"]}/{$LoadPage}.md")) {
		$TextType = "markdown";
		$RawText = file_get_contents("{$config["system"]["pagepass"]}/{$LoadPage}.md");
	}elseif (file_exists("{$config["system"]["pagepass"]}/{$LoadPage}.php")) {
		$TextType = "php";
		$RawText = file_get_contents("{$config["system"]["pagepass"]}/{$LoadPage}.php");
	}elseif (file_exists("{$config["system"]["pagepass"]}/{$LoadPage}.html")) {
		$TextType = "html";
		$RawText = file_get_contents("{$config["system"]["pagepass"]}/{$LoadPage}.html");
	}else{
		http_response_code(404);
		echo error("404 NotFound",$config["system"]["pagepass"],"The appointed file does not exist.",$version);
		exit;
	}
}


$RawTopmenu = file_get_contents("{$config["system"]["pagepass"]}/{$config["general"]["topmenu"]}");
$RawSidebar = file_get_contents("{$config["system"]["pagepass"]}/{$config["general"]["sidebar"]}");

$Wikiname = $config["general"]["name"];
$Message = $config["general"]["message"];
$Topmenu = $RawTopmenu;
$Pagetitle = "{$LoadPage}";
$Pagedate = "";
$Sidebar = $RawSidebar;
$Footer = $config["general"]["footer"];
$Theme = $config["general"]["theme"];


$Author = $config["meta"]["author"];
$Description = $config["meta"]["description"];
$Keyword = $config["meta"]["keyword"];
$Styletype = $config["meta"]["styletype"];
$Scripttype = $config["meta"]["scripttype"];
$Robots = $config["meta"]["robots"];
$Generator = $config["meta"]["generator"];

//PluginLoader
if ($plugin["plugin"]["is"] == "enable") { 
	foreach($plugin as $plugin_name => $val1) {
		if ($plugin[$plugin_name]["is"] === "enable") {
			include "plugin/{$plugin_name}/main.php";
		}
	}
}

//SpecialPageLoader
if (!($Mode == "view")) {
	include "system/{$Mode}.php";
}
include "theme/{$Theme}/theme.php";
?>
