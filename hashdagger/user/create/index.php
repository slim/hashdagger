<?php
	require "../../../ini.php";
	require "../../../lib/activerecord.php";
	require "../../../lib/person.php";
	require "../../../lib/user.php";
	ActiveRecord::$db = $ini['DB'];
	Person::$db = $ini['DB'];
	User::$db = $ini['DB'];
	
	$USER = User::httpAuth();
	
	$person = Person::selectById($_GET["person_id"]);
	$person->becomeUser();
	$message .= "Bonjour et bienvenue,\nVous pouvez vous connecter à votre compte sur: http://hd.afkar.tn/ \n";
	$message .= "Login: ".$person->login."\nPassword: ".$person->password;

	mail($person->mail, "Afkar - Vos codes d'accès", $message, "From: ".$USER->email);
?>