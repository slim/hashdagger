<?php
	require "../ini.php";
	require "../lib/user.php";
	User::$db = $ini['DB'];
	$USER = User::httpAuth();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Home - HashDagger</title> 
	<link rel="stylesheet" type="text/css" href="./css/barred.css" />
	<link rel="stylesheet" type="text/css" href="./css/wforms.css" />
</head>
<body dir="rtl">
<div id="entete" style="background: white; box-shadow: 0 0 8px rgb(0,0,0)">
<img src="./png/afkar-89x100.png" />
<p style="float:left">
<a href="./enter/person/" class="bouton">تسجيل ناخب</a>
<a href="./search/person/" class="bouton">قائمة الناخبين</a>
<a href="./enter/canvass/" class="bouton">حشد</a>
</p>
</div>
<p>
<a href="./enter/person/?person_id=<?php echo $USER->person_id ?>" class="bouton">تغيير معطياتي</a>
<a href="./enter/password/" class="bouton">تغيير كلمة السر</a>
<p>
</body>
</html>
