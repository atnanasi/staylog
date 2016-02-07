<?php
//Staylog new.php
//Copyright (c) 2016 Atnanasi

//PageText
$unixtime =time();

$Pagetext = <<< EOT
<form action="index.php?mode=control&do=newpage" method="post">
PageName:<input type="text" name="name" size="40" value=""><br>
<textarea name="text" cols="100" rows="20"></textarea>
Tags(A comma-separated):<input type="text" name="tags" size="80" value=""><br>
TextType(Recommend:MarkDown):<select name="type">
<option value="markdown">MarkDown</option>
<option value="html">HTML</option>
<option value="text">PlainText</option>
<option value="php">PHP</option>
</select>
Priority(Recommend:standard):<select name="priority">
<option value="standard">Standard</option>
<option value="high">High</option>
<option value="system">System</option>
</select>
<br>
<input type="radio" name="filename" value="auto" checked>Automatic generation (Example {$unixtime})
<input type="radio" name="filename" value="manual">Manual
PageFileName:<input type="text" name="file" size="20" value="{$LoadPage}"><br>
<input type="submit" value="Save" />
</form>
EOT;

$Pagetitle = "New";

?>