<?php
function isChecked($datetime)
{
	return !(trim($datetime) == "0000-00-00 00:00:00" || !trim($datetime));
}

function checkBox($datetime)
{
	if(isChecked($datetime)) return "&#8730;";
	else return "";
}
?>