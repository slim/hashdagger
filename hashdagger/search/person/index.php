<?php
	require "../../../ini.php";
	require "../../../lib/activerecord.php";
	require "../../../lib/person.php";
	require "../../../lib/user.php";
	ActiveRecord::$db = $ini['DB'];
	Person::$db = $ini['DB'];
	User::$db = $ini['DB'];	
	$USER = User::httpAuth();
	
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
		echo "<td>".$person->will_vote."</td>";
		echo "<td>".$person->for_party."</td>";
		echo "<td>".$person->for_independent."</td>";
		echo "<td>".$person->opinion."</td>";
		echo "<td>".$person->is_supporter."</td>";
		echo "<td>".$person->is_volunteer."</td>";
		echo "<td>".$person->note."</td>";
		echo "</tr>";
	}
?>
	</tbody>
	</table>