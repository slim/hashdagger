<?php 
	require "../../../includes/util.php";
	require "../../../ini.php";
	require "../../../lib/person.php";
	require "../../../lib/user.php";
	Person::$db = $ini['DB'];
	User::$db = $ini['DB'];	
	$USER = User::httpAuth();
	
	$person = Person::selectById($USER->id);

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- service -->
<head>
	<title>Modify password - HashDagger</title> 
	<link rel="stylesheet" type="text/css" href="../../css/barred.css" />
	<link rel="stylesheet" type="text/css" href="../../css/wforms.css" />
	<script type="text/javascript" src="../../js/jquery.min.js"></script>
	<script type="text/javascript" src="../../js/jquery.validate.js"></script>
	<script type="text/javascript" src="scripts.js"></script>
	
</head>
<body dir="rtl">
 <form id="form_password" action="../../password/modify/" method="post">
    
  <fieldset>
  <legend>تغيير كلمة السر</legend>
	<label>إسم التسجيل <input name="login" id="login" class="required" type="text" value="<?php echo $person->login ?>" /></label>
	<label>كلمة السر<input name="password" id="password" type="password" value="" /></label>
	<label>كلمة السر مرةً أخرى<input name="password2" id="password2" type="password" value="" /></label>
    
  </fieldset>
    
  <p><button type="submit">تسجيل</button><button type="button" onclick="location.href='../..'">رجوع</button></p>
 </form>

