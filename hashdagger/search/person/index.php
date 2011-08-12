<?php
	require "../../../includes/util.php";
	require "../../../ini.php";
	require "../../../lib/person.php";
	require "../../../lib/user.php";
	Person::$db = $ini['DB'];
	User::$db = $ini['DB'];	
	$USER = User::httpAuth();
	if(!$_GET['user_id']) $_GET['user_id'] = $USER->id;
	$persons = Person::selectByUser($_GET['user_id']);

	?>
	<html xmlns="http://www.w3.org/1999/xhtml">
	<!-- service -->
	<head>
		<title>Canvass - HashDagger</title> 
		<link rel="stylesheet" type="text/css" href="../../css/barred.css" />
		<link rel="stylesheet" type="text/css" href="../../css/wforms.css" />
	</head>
	<body dir="rtl">
	<table>
	<thead>
	<tr>
		<th>السم و اللقب</th>
		<th>العمر</th>
		<th>الهاتف</th>
		<th>البريد الالكتروني</th>
		<th>انتخاب</th>
		<th>الاحزاب</th>
		<th>القوائم المستقلة</th>
		<th>لماذا؟</th>
		<th>مساند</th>
		<th>متطوع</th>
		<th>ملاحظة</th>
		<th></th>
	</tr>
	</thead>
	<tbody>
	<?php
	foreach($persons AS $person)
	{
		echo "<tr>";
		echo '<td><a href="../../enter/person/?person_id='.$person->id.'">'.$person->name.'</a></td>';
		echo "<td>".$person->age."</td>";
		echo "<td>".$person->phone."</td>";
		echo "<td>".$person->mail."</td>";
		echo "<td align='center'>".checkBox($person->will_vote)."</td>";
		echo "<td align='center'>".checkBox($person->for_party)."</td>";
		echo "<td align='center'>".checkBox($person->for_independent)."</td>";
		echo "<td>".$person->opinion."</td>";
		echo "<td align='center'>".checkBox($person->is_supporter)."</td>";
		echo "<td align='center'>".checkBox($person->is_volunteer)."</td>";
		echo "<td>".$person->note."</td>";
		echo "<td>";
		if(!isChecked($person->is_user) && $person->mail)
			echo '<a href="../../user/create/?person_id='.$person->id.'">إنشاء مستخدم</a>';
		else if(isChecked($person->is_user))
			echo '<a href="../../password/generate/?person_id='.$person->id.'">تغير كلمة العبور</a>';
		echo "</td>";
		echo "</tr>";
	}
?>
	</tbody>
	</table>
