<?php
	require "../../ini.php";
	require "../../lib/activerecord.php";
	require "../../lib/canvass.php";
	require "../../lib/place.php";
	require "../../lib/person.php";
	require "../../lib/opinion.php";
	Canvass::$db = $ini['DB'];
	Opinion::$db = $ini['DB'];
	ActiveRecord::$db = $ini['DB'];

print_r($_POST);

if ($_POST['canvass-begin'] && $_POST['canvass-end']) {
	$house = new Place;
	$house->region   = $_POST['region'];
	$house->district = $_POST['district'];
	$house->street   = $_POST['street'];
	$house->building = $_POST['building-num'];
	$house->level	 = $_POST['level-num'];
	$house->house    = $_POST['house-num'];
	$house->insert();
	$canvass = new Canvass($house);
	$canvass->begin = $_POST['canvass-begin']; 
	$canvass->end   = $_POST['canvass-end']; 
	if (!$_POST['door-closed']) $canvass->opened_door = date("c");
	if ($_POST['answered-questions']) $canvass->answered_questions = date("c");
	$canvass->insert();
}
if ($canvass->answered_questions) {
	$person = new Person;
	$person->name  = $_POST['person-name'];
	$person->age   = $_POST['person-age'];
	$person->phone = $_POST['person-phone'];
	$person->mail  = $_POST['person-mail'];
	$person->insert();
	$canvass->talkedTo($person);
	$opinion = new Opinion($person);
	if ($_POST['will-vote']) $opinion->will_vote = date("c");
	if ($_POST['for-party']) $opinion->for_party = date("c");
	if ($_POST['for-independent']) $opinion->for_independent = date("c");
	$opinion->reason = $_POST['reason'];
	if ($_POST['supporter']) $opinion->is_supporter = date("c");
	if ($_POST['volunteer']) $opinion->is_volunteer = date("c");
	$opinion->note = $_POST['note'];
	$opinion->insert();
}
