<?php
	require "../../ini.php";
	require "../../lib/activerecord.php";
	require "../../lib/person.php";
	require "../../lib/user.php";
	ActiveRecord::$db = $ini['DB'];
	Person::$db = $ini['DB'];
	User::$db = $ini['DB'];
	
	$USER = User::httpAuth();
	
	$person = new Person();
	$person->getData($_POST);
	$person->user_id = $USER->id;
	if($person->id)
		$person->update();
	else
		$person->insert();

