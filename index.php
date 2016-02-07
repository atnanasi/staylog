<?php
//Staylog index.php
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

if (isset($_GET["q"])) {
	$LoadPage = htmlspecialchars($_GET["q"]);
}else{
	$LoadPage = "index";
}

if (isset($_GET["mode"])) {
	$SystemMode = $_GET["mode"];
}else{
	$SystemMode = "view";
}

//Error check

if (strstr($LoadPage,"..")) {
	http_response_code(404);
	echo Error("404 NotFound",$ErrorPage,"It's an unjust URL.",$version);
	exit;
}elseif (ExistsPage($LoadPage)) {
	$PageData = GetPage ($LoadPage);
	$RawText = file_get_contents("page/{$LoadPage}/{$PageData["filename"]}");
}else{
	http_response_code(404);
	echo Error("404 NotFound",$ErrorPage,"The appointed file does not exist.",$version);
	exit;
}

if (ExistsPage($config["general"]["topmenu"])) {
	$TopmenuArray = GetPage($config["general"]["topmenu"]);
	$RawTopmenu = file_get_contents("page/{$config["general"]["topmenu"]}/{$TopmenuArray["filename"]}");
}else{
	http_response_code(404);
	echo Error("404 NotFound",$ErrorPage,"System file does not exist.",$version);
	exit;
}

if (ExistsPage($config["general"]["sidebar"])) {
	$SidebarArray = GetPage($config["general"]["sidebar"]);
	$RawSidebar = file_get_contents("page/{$config["general"]["sidebar"]}/{$SidebarArray["filename"]}");
}else{
	http_response_code(404);
	echo Error("404 NotFound",$ErrorPage,"System file does not exist.",$version);
	exit;
}

$Blogname = $config["general"]["name"];
$Message = $config["general"]["message"];
$Topmenu = $RawTopmenu;
$Pagetitle = $PageData["title"];
$TextType = $PageData["type"];
$PageTag = $PageData["tag"];
$PageAuthor = $PageData["author"];
$PagePriority = $PageData["priority"];
$Pagedate = $PageData["date"];
$Pagetime = $PageData["time"];
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

include "function/{$SystemMode}.php";

include "theme/{$Theme}/theme.php";
?>
