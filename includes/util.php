<?php
function isChecked($datetime)
{
	if(trim($datetime) == "0000-00-00 00:00:00")
		return false;
	else 
		return true;
}

function checkBox($datetime)
{
	if(isChecked($datetime)) return "&#8730;";
	else return "";
}
?>