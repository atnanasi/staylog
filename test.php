<?php
require_once"lib/stayfunc.php";
$Data = GetPageList();
for ($i = 0; $i < count($Data); $i++) {
	$InData = GetPage($Data[$i]);
	if ($InData["priority"] !== "system") {
		$Sort[$i] = $Data[$i];
	}
}

rsort($Sort);
print_r($Sort);

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
	echo "<h2>{$InData["title"]}<span>{$InData["date"]} {$InData["time"]}</span></h2>\n";
}

print_r($Sorted);