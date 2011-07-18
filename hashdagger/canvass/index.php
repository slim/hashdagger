<?php
	require "../../ini.php";
	require "../../lib/activerecord.php";
	require "../../lib/canvass.php";
	require "../../lib/person.php";
	require "../../lib/user.php";
	Canvass::$db = $ini['DB'];
	ActiveRecord::$db = $ini['DB'];
	User::$db = $ini['DB'];
	
	$USER = User::httpAuth();

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
