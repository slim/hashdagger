<?php
	require "../../ini.php";
	require "../../lib/activerecord.php";
	require "../../lib/person.php";
	ActiveRecord::$db = $ini['DB'];

print_r($_POST);

	$person = new Person;
	$person->name  = $_POST['person-name'];
	$person->age   = $_POST['person-age'];
	$person->phone = $_POST['person-phone'];
	$person->mail  = $_POST['person-mail'];
		
	if ($_POST['will-vote']) $person->will_vote = date("c");
	if ($_POST['for-party']) $person->for_party = date("c");
	if ($_POST['for-independent']) $person->for_independent = date("c");
	$person->opinion = $_POST['reason'];
	if ($_POST['supporter']) $person->is_supporter = date("c");
	if ($_POST['volunteer']) $person->is_volunteer = date("c");
	$person->note = $_POST['note'];
	
	$person->insert();

