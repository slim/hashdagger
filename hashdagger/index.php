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
<p id="entete">
<a href="./enter/person/" class="bouton">تسجيل ناخب</a>
<a href="./search/person/" class="bouton">قائمة الناخبين</a>
<a href="./enter/canvass/" class="bouton">حشد</a>
</p>
<a href="./enter/person/?person_id=<?php echo $USER->id ?>" class="bouton">تغيير معطياتي</a>
</body>
</html>
