<?php

require "../../../ini.php";
require "../../../lib/person.php";
require "../../../lib/user.php";
Person::$db = $ini['DB'];
User::$db = $ini['DB'];

$USER = User::httpAuth();

$person = new Person();
$person->user_id = $USER->id;
$person->user_key = $USER->user_key;
if($_GET["phone"])
{
	$person->phone = $_GET["phone"];
	if($person->existPhone()) echo "هذا الرقم مستعمل";
}
else if($_GET["mail"])
{
	$person->mail = $_GET["mail"];
	if($person->existMail()) echo "هذا البريد الالكتروني مستعمل";
}
//if (!$person->name && !($person->phone || $person->email)) die("<div class='message_erreur'>المعطيات غير كافية للتسجيل</div>");
//if($person->exist()) die("<div class='message_erreur'>لا يمكن التسجيل بنفس المعطيات</div>");
?>