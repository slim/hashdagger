<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Person - HashDagger</title> 
	<link rel="stylesheet" type="text/css" href="../css/barred.css" />
</head>
<body dir="rtl">
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
	if (!$person->name && !($person->phone || $person->email)) die("<div class='message_erreur'>المعطيات غير كافية للتسجيل</div>");
	if($person->id)
		$person->update();
	else
		$person->insert();

	print "<div class='message_notification'>تم تسجيل الناخب</div><br /><a class='bouton' href='../'>الرجوع إلى الصفحة الرئيسية</a>";
?>
</body></html>
