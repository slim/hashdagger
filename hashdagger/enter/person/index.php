<?php 
	require "../../../includes/util.php";
	require "../../../ini.php";
	require "../../../lib/activerecord.php";
	require "../../../lib/person.php";
	require "../../../lib/user.php";
	ActiveRecord::$db = $ini['DB'];
	Person::$db = $ini['DB'];
	User::$db = $ini['DB'];	
	$USER = User::httpAuth();
	
	if($_GET["person_id"])
	{
		$person = Person::select($_GET['person_id']);
		$person = $person[0];
	}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- service -->
<head>
	<title>Opinion - HashDagger</title> 
	<link rel="stylesheet" type="text/css" href="../../css/barred.css" />
	<link rel="stylesheet" type="text/css" href="../../css/wforms.css" />
	<script type="text/javascript" src="../../js/jquery.min.js"></script>
	<script type="text/javascript" src="../../js/jquery.validate.js"></script>
	<script type="text/javascript" src="../../js/scripts.js"></script>
	
</head>
<body dir="rtl">
 <form id="form_person" action="../../person/" method="post">
  
  <fieldset><legend>شخص</legend>
  <p>
  <label>السم و اللقب<input class="required" name="person-name" id="name" type="text" value="<?php echo $person->name; ?>" /></label>
  <label>العمر<input class="digits" name="person-age" id="age" type="text" value="<?php echo $person->age ?>" /></label>
  <label>الهاتف<input dir="ltr" class="digits" name="person-phone" id="phone" type="text" value="<?php echo $person->phone ?>" /></label>
  <label>البريد الالكتروني<input dir="ltr" class="email" name="person-mail" id="email" type="text" value="<?php echo $person->mail ?>" /></label>
  </p>
  </fieldset>

  <fieldset><legend>رأي</legend>
  <p>
  <label>انتخاب<input name="will-vote" type="checkbox" <?php if(isChecked($person->will_vote)) echo 'checked' ?> /></label>
  <label>الاحزاب<input name="for-party" type="checkbox" <?php if(isChecked($person->for_party)) echo 'checked' ?> /></label>
  <label>القوائم المستقلة<input name="for-independent" type="checkbox" <?php if(isChecked($person->for_independent)) echo 'checked' ?> /></label>
  <label>لماذا؟<input name="reason" type="text" value="<?php echo $person->opinion ?>" /></label>
  </p>
  <p>
  <label>مساند<input name="supporter" type="checkbox" <?php if(isChecked($person->is_supporter)) echo 'checked' ?> /></label>
  <label>متطوع<input name="volunteer" type="checkbox" <?php if(isChecked($person->is_volunteer)) echo 'checked' ?>/></label>
  <label>ملاحظة<input name="note" type="text" value="<?php echo $person->note ?>" /></label>
  </p>
  </fieldset>
  <?php if($_GET["person_id"]) { ?>
  <input type="hidden" name="person_id" value="<?php echo $_GET['person_id'] ?>" />
  <fieldset>
  <?php if(!isChecked($person->is_user)) {?>
  <legend>مستعمل البرنامج <input type="checkbox" class="is_user" name="is_user" id="is_user" <?php if(isChecked($person->is_user)) echo 'checked' ?> /> </legend>
  	<div class="user_bloc_empty">
  	هذا الشخص لا يستعمل البرنامج
  	</div>
  	<div class="user_bloc" id="user_bloc">
	<label>إسم التسجيل <input name="login" id="login" class="required" type="text" value="<?php echo $person->login ?>" /></label>
	<label>كلمة السر<input name="password" id="password" type="password" value="" /></label>
	<label>كلمة السر مرةً أخرى<input name="password2" id="password2" type="password" value="" /></label>
	</div>  
  <?php } else { ?>
  <legend>مستعمل البرنامج </legend>
    <div>
  	هذا الشخص يستعمل البرنامج
  	</div>
  <?php } ?>
  
  </fieldset>
  <?php } ?>
  
  <input type="submit" />
 </form>

</body>
</html>

