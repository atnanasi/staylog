<?php
//Staylog edit.php-1.00
//Copyright (c) 2016 Atnanasi

//PageText
$Pagetext = <<< EOT
<form action="index.php?mode=control&q={$LoadPage} method="post">
PageName:<input type="text" name="name" size="20" value="{$Pagetitle}"><br>
<textarea name="text" cols="100" rows="20">
{$RawText}
</textarea></p>
PageFileName:<input type="text" name="file" size="20" value="{$LoadPage}" readonly>(You can't change page name.)<br>
<input type="submit" value="Save" />
</form>
</html>
EOT;

$Pagetitle = "Edit - {$Pagetitle}";
