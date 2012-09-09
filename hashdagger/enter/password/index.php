<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Modify password - HashDagger</title> 
	<link rel="stylesheet" type="text/css" href="../../css/barred.css" />
	<link rel="stylesheet" type="text/css" href="../../css/wforms.css" />
	<script type="text/javascript" src="../../js/jquery.min.js"></script>
	<script type="text/javascript" src="../../js/jquery.validate.js"></script>
	<script type="text/javascript" src="scripts.js"></script>
	
</head>
<body dir="rtl">
<div id="entete" style="background: white; box-shadow: 0 0 8px rgb(0,0,0)">
<img src="../../png/hashdagger-129x100.png" />
</div>
 <form id="form_password" action="../../password/modify/" method="post">
    
  <fieldset>
  <legend>تغيير كلمة السر</legend>
	<label>كلمة السر<input name="password" id="password" type="password" value="" /></label>
	<label>كلمة السر مرةً أخرى<input name="password2" id="password2" type="password" value="" /></label>
    
  </fieldset>
    
  <p><button type="submit">تسجيل</button><button type="button" onclick="location.href='../..'">رجوع</button></p>
 </form>

