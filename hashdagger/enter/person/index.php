<?php 
	require "../../../includes/util.php";
	require "../../../ini.php";
	require "../../../lib/person.php";
	require "../../../lib/user.php";
	Person::$db = $ini['DB'];
	User::$db = $ini['DB'];	
	$USER = User::httpAuth();
	
	if($_GET["person_id"])
	{
		$person = Person::selectById($_GET['person_id']);
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
	<script type="text/javascript" src="scripts.js"></script>
	
</head>
<body dir="rtl">
<div id="entete" style="background: white; box-shadow: 0 0 8px rgb(0,0,0)">
<img src="../../png/afkar-89x100.png" />
</div>
 <form id="form_person" action="../../person/" method="post">
  
  <fieldset><legend>شخص</legend>
  <p>
  <label>السم و اللقب<input class="required" name="person-name" id="name" type="text" value="<?php echo $person->name; ?>" /></label>
  <label>العمر<input class="digits" name="person-age" id="age" type="text" size="3" value="<?php echo $person->age ?>" /></label>
  <label>الهاتف<input dir="ltr" class="digits" name="phone" id="phone" type="text" size="11" value="<?php echo $person->phone ?>" onBlur="testExistPhone(this)" /></label>
  <label>البريد الالكتروني<input dir="ltr" class="email" name="email" id="email" type="text" value="<?php echo $person->mail ?>" onBlur="testExistMail(this)" /></label>
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
  <?php if (isChecked($person->is_user)) { ?>
  <fieldset>
    <div>
  	هذا الشخص يستعمل البرنامج
  	</div>
  <?php } ?>
  
  </fieldset>
  <?php } ?>
  
  <p><button type="submit">تسجيل</button><button type="button" onclick="location.href='../..'">رجوع</button></p>
 </form>

