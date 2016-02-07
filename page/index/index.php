<?php
//"<h2>{$title}<span>{$date} {$time}</span></h2>\n";
$Pagetext = "";
$Data = GetPageList();
for ($i = 0; $i < count($Data); $i++) {
	$InData = GetPage($Data[$i]);
	if ($InData["priority"] !== "system") {
		$Sort[$i] = $Data[$i];
	}
}

rsort($Sort);

for ($i = 0; $i < count($Sort); $i++) {
	$InData = GetPage($Sort[$i]);
	if ($InData["priority"] == "high") {
		$Sorted[] = $Sort[$i];
	}
}

for ($i = 0; $i < count($Sort); $i++) {
	$InData = GetPage($Sort[$i]);
	if ($InData["priority"] == "standard") {
		$Sorted[] = $Sort[$i];
	}
}

for ($i = 0; $i < count($Sorted); $i++) {
	$InData = GetPage($Sorted[$i]);
	$Pagetext .= "<h2>{$InData["title"]}<span>{$InData["date"]} {$InData["time"]}</span></h2>\n";
	$Line = explode("\n", rtrim(file_get_contents("page/{$Sorted[$i]}/{$InData["filename"]}"), "\n"));
	
	if (count($Line) < 5) {
		$cnt = count($Line);
	}else{
		$cnt = 5;
	}
	for ($s = 0; $s < $cnt; $s++) {
		$Pagetext .= ParseFile($InData["type"], $Line[$s]."\n");
	}
	$Pagetext .= "<br>\n";
	$Pagetext .= "<a href=\"index.php?q={$Sorted[$i]}\">Read more...</a>";
}
