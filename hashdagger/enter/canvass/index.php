<html xmlns="http://www.w3.org/1999/xhtml">
<!-- service -->
<head>
	<title>Canvass - HashDagger</title> 
	<link rel="stylesheet" type="text/css" href="../../css/barred.css" />
	<link rel="stylesheet" type="text/css" href="../../css/wforms.css" />
</head>
<body dir="rtl">
<h1>حشد</h1>

 <form action="../../canvass/" method="post">
  <fieldset><legend>حشد</legend>
  <p>
  <label>البداية <input dir="ltr" name="canvass-begin" type="text" /></label>
  <label>النهاية <input dir="ltr" name="canvass-end" type="text" /></label>
  </p>
  <fieldset><legend>المنزل</legend>
  <p>
  <label>المنطقة<input name="region" type="text" /></label>
  <label>الدائرة<input name="round" type="text" /></label>
  <label>النهج<input name="street" type="text" /></label>
  <label>رقم البناية<input name="building-num" type="text" /></label>
  <label>الطابق<input name="level-num" type="text" /></label>
  <label>الشقة/المنزل<input name="house-num" type="text" /></label>
  </p>
  </fieldset>
  <p>
  <label>فتح الباب و التجاوب<input name="answered-questions" type="checkbox" /></label>
  <label>لا يوجد أحد في المنزل<input name="door-closed" type="checkbox" /></label>
  </p>
  </fieldset>


  <fieldset><legend>شخص</legend>
  <p>
  <label>السم و اللقب<input name="person-name" type="text" /></label>
  <label>العمر<input name="person-age" type="text" /></label>
  <label>الهاتف<input dir="ltr" name="person-phone" type="text" /></label>
  <label>البريد الالكتروني<input dir="ltr" name="person-mail" type="text" /></label>
  </p>
  </fieldset>

  <fieldset><legend>رأي</legend>
  <p>
  <label>انتخاب<input name="will-vote" type="checkbox" /></label>
  <label>الاحزاب<input name="for-party" type="checkbox" /></label>
  <label>القوائم المستقلة<input name="for-independent" type="checkbox" /></label>
  <label>لماذا؟<input name="reason" type="text" /></label>
  </p>
  <p>
  <label>مساند<input name="supporter" type="checkbox" /></label>
  <label>متطوع<input name="volunteer" type="checkbox" /></label>
  <label>ملاحظة<input name="note" type="text" /></label>
  </p>
  </fieldset>

  <input type="submit" />
 </form>

</body>
</html>

