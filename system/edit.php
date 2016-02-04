<?php
//Staylog edit.php-1.00
//Copyright (c) 2016 Atnanasi

//ErrorCheck
if (!(isset($_GET["page"]))) {
	http_response_code(404);
	echo error("404 NotFound",$config["system"]["pagepass"],"It's an unjust URL.");
	exit;
}

if (file_exists("system/{$_GET["page"]}.php")) {
		$EditTextType = "php";
		$EditText = file_get_contents("system/{$_GET["page"]}.php");
	}elseif (file_exists("{$config["system"]["pagepass"]}/{$_GET["page"]}.md")) {
		$EditTextType = "markdown";
		$EditText = file_get_contents("{$config["system"]["pagepass"]}/{$_GET["page"]}.md");
	}elseif (file_exists("{$config["system"]["pagepass"]}/{$_GET["page"]}.html")) {
		$EditTextType = "html";
		$EditText = file_get_contents("{$config["system"]["pagepass"]}/{$_GET["page"]}.html");
	}else{
		http_response_code(404);
		echo error("404 NotFound",$config["system"]["pagepass"],"The appointed file does not exist.",$version);
		exit;
}
$Pagetitle = "Edit - {$_GET["page"]}";

//PageText
$Pagetext = <<< EOT
<form action="system/system.php?mode=edit" method="post">
PageName:<input type="text" name="name" size="20" value="{$_GET["page"]}" readonly>(You can't change page name.)<br>
<textarea name="text" cols="100" rows="20">
{$EditText}
</textarea></p>
<input type="submit" value="Save" />
</form>
</html>
EOT;

return $Pagetext;