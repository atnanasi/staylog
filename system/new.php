<?php
//New

//ErrorCheck
if (!(isset($_GET["q"]))) {
	http_response_code(404);
	echo error("404 NotFound",$config["system"]["pagepass"],"It's an unjust URL.");
	exit;
}

if (file_exists($config["system"]["pagepass"]."/".$_GET["q"].".md")) {
	echo error("Exist File",$config["system"]["pagepass"],"The file has already existed.");
	exit;
}else{
	$Pagetitle = "New - {$LoadPage}";
}

//PageText
$Pagetext = <<< EOT
<form action="system/system.php?mode=new" method="post">
PageName:<input type="text" name="name" size="20" value="{$_GET["q"]}" readonly>(You can't change page name.)<br>
<textarea name="text" cols="100" rows="20">
</textarea></p>
<input type="submit" value="Save" />
</form>
</html>
EOT;
