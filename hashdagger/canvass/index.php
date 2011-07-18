<?php
	require "../../ini.php";
	require "../../lib/activerecord.php";
	require "../../lib/canvass.php";
	require "../../lib/person.php";
	Canvass::$db = $ini['DB'];
	ActiveRecord::$db = $ini['DB'];

print_r($_POST);

if ($_POST['canvass-begin'] && $_POST['canvass-end']) {
	$canvass = new Canvass();
	$canvass->getData($_POST);
	$canvass->insert();
}
if ($canvass->answered_questions) {
	$person = new Person;
	$person->getData($_POST);
	$person->insert();
	
	$canvass->talkedTo($person);
}
