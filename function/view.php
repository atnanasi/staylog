<?php
//Staylog view.php
//Copyright (c) 2016 Atnanasi

if (!(ExistsPage($LoadPage))) {
	http_response_code(404);
	echo Error("404 NotFound",$ErrorPage,"The appointed file does not exist.",$version);
}