<?php
	require "../../ini.php";
	require "../../lib/activerecord.php";
	require "../../lib/person.php";
	ActiveRecord::$db = $ini['DB'];

print_r($_POST);

	$person = new Person;
	$person->getData($_POST);	
	$person->insert();

