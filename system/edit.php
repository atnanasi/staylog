<?php
//Edit

//ErrorCheck
if (!(isset($_GET["q"]))) {
	http_response_code(404);
	echo error("404 NotFound",$config["system"]["pagepass"],"It's an unjust URL.");
	exit;
}

if (file_exists("{$config["system"]["pagepass"]}/{$LoadPage}.md")) {
		$TextType = "markdown";
		$EditText = file_get_contents("{$config["system"]["pagepass"]}/{$LoadPage}.md");
	}elseif (file_exists("{$config["system"]["pagepass"]}/{$LoadPage}.php")) {
		$TextType = "php";
		$EditText = file_get_contents("{$config["system"]["pagepass"]}/{$LoadPage}.php");
	}elseif (file_exists("{$config["system"]["pagepass"]}/{$LoadPage}.html")) {
		$TextType = "html";
		$EditText = file_get_contents("{$config["system"]["pagepass"]}/{$LoadPage}.html");
	}else{
		http_response_code(404);
		echo error("404 NotFound",$config["system"]["pagepass"],"The appointed file does not exist.",$version);
		exit;
}
$Pagetitle = "Edit - {$LoadPage}";

//PageText
$Pagetext = <<< EOT
<form action="system/system.php?mode=edit" method="post">
PageName:<input type="text" name="name" size="20" value="{$_GET["q"]}" readonly>(You can't change page name.)<br>
<textarea name="text" cols="100" rows="20">
{$EditText}
</textarea></p>
<input type="submit" value="Save" />
</form>
</html>
EOT;
