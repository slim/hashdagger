<?php
	require "../ini.php";
	require "../lib/user.php";
	User::$db = $ini['DB'];
	Person::$db = $ini['DB'];
	$USER = User::httpAuth();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Home - HashDagger</title> 
	<link rel="stylesheet" type="text/css" href="./css/barred.css" />
	<link rel="stylesheet" type="text/css" href="./css/wforms.css" />
<style>
dl.border-around
{
	margin: 2em 0;
	padding: 0;
	width: 7em;
}

.border-around dt
{
	float: right;
	background-color: green;
	color: lightgreen;
	padding: .3em;
	text-align: center;
	font-size: 12px;
	border-left: 1px solid green;
	border-right: 1px solid green;
	border-top: 1px solid green;
}

.border-around dd
{
	background-color: lightgreen;
	color: green;
	margin: 0 0 1em 0;
	text-align: center;
	font-weight: bold;
	font-size: 27px;
	padding: 1em .3em;
	border-left: 1px solid green;
	border-right: 1px solid green;
	border-bottom: 1px solid green;
	border-top: 1px solid green;
}
</style>
</head>
<body dir="rtl">
<div id="entete" style="background: white; box-shadow: 0 0 8px rgb(0,0,0)">
<img src="./png/hashdagger-129x100.png" />
<p style="float:left">
<a href="./enter/person/" class="bouton">تسجيل شخص</a>
<a href="./search/person/" class="bouton">قائمة الأشخاص</a>
<a href="./enter/canvass/" class="bouton">حشد</a>
</p>
</div>
<dl class='border-around'>
<dt>أشخاص</dt><dd><?php print Person::count() ?></dd>
<dt>مساندون</dt><dd><?php print $USER->countContacts() ?></dd>
</dl>
<p>
<a href="./enter/person/?person_id=<?php echo $USER->person_id ?>" class="bouton">تغيير معطياتي</a>
<a href="./enter/password/" class="bouton">تغيير كلمة السر</a>
<a href="./sql/dump/" class="bouton">Download Database</a>
<p>
</body>
</html>
