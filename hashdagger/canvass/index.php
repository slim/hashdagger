<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Canvass - HashDagger</title> 
	<link rel="stylesheet" type="text/css" href="../css/barred.css" />
</head>
<body dir="rtl">
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
	print "<div class='message_notification'>تم تسجيل الناخب</div><br /><a class='bouton' href='../'>الرجوع إلى الصفحة الرئيسية</a>";
?>
</body></html>
