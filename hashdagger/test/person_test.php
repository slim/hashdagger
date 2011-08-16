<?php
	require_once "../../lib/simpletest/autorun.php";
	require_once "../../lib/person.php";
	require_once "../../lib/user.php";

	$USER = new User;
	$USER->user_key = "1234567890123456";
	$USER->password = "6543210987654321";
	$PERSON = new Person;
	$PERSON->name = "Slim Amamou";
	$PERSON->mail = "slim.amamou@gmail.com";
	$PERSON->user_id= $USER->id;

class TestOfPerson extends UnitTestCase {
	function setUp()
	{
		$this->db = new PDO("mysql:host=localhost;dbname=hashdagger_test", "root");
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		Person::$db = $this->db;
	}

	function testInsertEncryptsPersonalInfo()
	{
		global $USER, $PERSON;

		$PERSON->insert();
	    $result = $this->db->query("select * from person where id='".$PERSON->id."'");
		$p = $result->fetch();
		$this->assertEqual(md5($p['name']), "e43275f823f1e9064fa6d4a31def8a07"); //"Slim Amamou" AES encrypted with "1234567890123456"

	}

	function testSelectDecryptsPersonalInfo()
	{
		global $USER, $PERSON;

		$p = Person::selectById($PERSON->id);

		$this->assertEqual($p->name, "Slim Amamou");
	}
}
