<?php
	require "../../ini.php";
	require "../../lib/activerecord.php";
	require "../../lib/person.php";
	require "../../lib/user.php";
	ActiveRecord::$db = $ini['DB'];
	User::$db = $ini['DB'];
	
	$USER = User::httpAuth();
	
print_r($_POST);

	$person = new Person;
	$person->getData($_POST);	
	$person->insert();

