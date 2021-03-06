<html xmlns="http://www.w3.org/1999/xhtml">
<!-- service -->
<head>
	<title>Canvass - HashDagger</title> 
	<link rel="stylesheet" type="text/css" href="../../css/barred.css" />
	<link rel="stylesheet" type="text/css" href="../../css/wforms.css" />
	<link rel="stylesheet" type="text/css" href="../../css/jquery-ui.css" />
	<script type="text/javascript" src="../../js/jquery.min.js"></script>
	<script type="text/javascript" src="../../js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="../../js/jquery-ui-timepicker-addon.js"></script>
	<script type="text/javascript">
	jQuery(document).ready(function () {
		$('#canvass-end').datetimepicker();
		$('#canvass-begin').datetimepicker();
	});
	</script>
	<style type="text/css"> 
			
			#ui-datepicker-div{ font-size: 80%;}
			
			/* css for timepicker */
			.ui-timepicker-div th{border-style: none;}
			.ui-timepicker-div .ui-widget-header{ margin-bottom: 8px; }
			.ui-timepicker-div dl{ text-align: left; }
			.ui-timepicker-div dl dt{ height: 25px; border-bottom: none; float:none; margin-top:none;}
			.ui-timepicker-div dl dd{ margin: -25px 10px 10px 65px; clear:left;}
			.ui-timepicker-div table tr td { font-size: 90%; border-spacing: 13px; clear: none; border-width:10px;}
			.ui-timepicker-div table {clear: none; border-spacing:10px; border-width:10px;}
			
		</style> 
	
</head>
<body dir="rtl">
<div id="entete" style="background: white; box-shadow: 0 0 8px rgb(0,0,0)">
<img src="../../png/hashdagger-129x100.png" />
</div>

 <form action="../../canvass/" method="post">
  <fieldset><legend>حشد</legend>
  <p>
  <label>البداية <input dir="ltr" name="canvass-begin" id="canvass-begin" type="text" size="15" /></label>
  <label>النهاية <input dir="ltr" name="canvass-end" id="canvass-end" type="text" size="15" /></label>
  </p>
  <fieldset><legend>المكان</legend>
  <p>
  <label>المنطقة<input name="region" type="text" /></label>
  <label>الدائرة<input name="round" type="text" /></label>
  <label>النهج<input name="street" type="text" /></label>
  <label>رقم البناية<input name="building-num" type="text" size="3" /></label>
  <label>الطابق<input name="level-num" type="text" size="3" /></label>
  <label>الشقة/المنزل<input name="house-num" type="text" size="3" /></label>
  </p>
  </fieldset>
  <p>
  <label>فتح الباب و تجاوب<input name="answered-questions" type="checkbox" /></label>
  <label>لا يوجد أحد في المكان<input name="door-closed" type="checkbox" /></label>
  </p>
  </fieldset>


  <fieldset><legend>شخص</legend>
  <p>
  <label>السم و اللقب<input name="person-name" type="text" /></label>
  <label>العمر<input name="person-age" type="text" size="3" /></label>
  <label>الهاتف<input dir="ltr" name="phone" type="text" size="11" /></label>
  <label>البريد الالكتروني<input dir="ltr" name="mail" type="text" /></label>
  </p>
  </fieldset>

  <fieldset><legend>رأي</legend>
  <p>
  <label>سيتفاعل<input name="will-vote" type="checkbox" /></label>
  <label>معنا<input name="for-independent" type="checkbox" /></label>
  <label>مع المنافسين<input name="for-party" type="checkbox" /></label>
  <label>لماذا؟<input name="reason" type="text" /></label>
  </p>
  <p>
  <label>مساند<input name="supporter" type="checkbox" /></label>
  <label>متطوع<input name="volunteer" type="checkbox" /></label>
  <label>ملاحظة<input name="note" type="text" /></label>
  </p>
  </fieldset>

  <p><button type="submit">تسجيل</button><button type="button" onclick="document.location.href='../..'">رجوع</button></p>
 </form>

</body>
</html>

