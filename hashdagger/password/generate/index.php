<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Person - HashDagger</title> 
	<link rel="stylesheet" type="text/css" href="../../css/barred.css" />
</head>
<body dir="rtl">
<?php
	require "../../../ini.php";
	require "../../../lib/activerecord.php";
	require "../../../lib/person.php";
	require "../../../lib/user.php";
	ActiveRecord::$db = $ini['DB'];
	Person::$db = $ini['DB'];
	User::$db = $ini['DB'];
	
	$USER = User::httpAuth();
	
	$user = new Person($_GET["person_id"]);
	$user->generatePassword();
	$message .= "Bonjour et bienvenue,\nVous pouvez vous connecter à votre compte sur: http://hd.afkar.tn/ \n";
	$message .= "Login: ".$user->login."\nPassword: ".$user->password;

	mail($user->mail, "Afkar - Vos codes d'accès", $message, "From: ".$USER->email);
	print "<div class='message_notification'>تم تغيير كلمة العبور و إعلام الاستخدم بذالك عبر البريد الالكتروني </div><br /><a class='bouton' href='../../'>الرجوع إلى الصفحة الرئيسية</a>";
?>
</body></html>