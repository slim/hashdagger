<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Person - HashDagger</title> 
	<link rel="stylesheet" type="text/css" href="../../css/barred.css" />
</head>
<body dir="rtl">
<?php
	require "../../../ini.php";
	require "../../../lib/person.php";
	require "../../../lib/user.php";
	Person::$db = $ini['DB'];
	User::$db = $ini['DB'];
	
	$USER = User::httpAuth();
	
	$person = Person::selectById($_GET["person_id"]);
	$u = $person->becomeUser();
	$message .= "Hello,\nYou can connect to your account here: http://hd.pirate.tn \n";
	$message .= "Login: ".$u->id ."\nPassword: ".$u->password;

	mail($u->mail, "HashDagger - New account", $message, "From: ".$USER->mail);
	print "<div class='message_notification'>تم إنشاء المستخدم و اعلامه عبر البريد الإلكتروني </div><br /><a class='bouton' href='../../'>الرجوع إلى الصفحة الرئيسية</a>";
?>
</body></html>
