<?php
// Markdown parser
require_once("plugin/{$plugin_name}/Michelf/Markdown.inc.php");
use Michelf\Markdown;
if ($TextType == "markdown") {
	$Pagetext = Markdown::defaultTransform($RawText);
}
?>
