<?php
	require_once "../../lib/simpletest/autorun.php";
	require_once "../../lib/person.php";
	require_once "../../lib/user.php";

class TestOfPerson extends UnitTestCase {
	function setUp()
	{
		$this->db = new PDO("mysql:host=localhost;dbname=hashdagger_test", "root");
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		Person::$db = $this->db;
		$this->person = new Person;
		$this->person->name = "Slim Amamou";
		$this->person->mail = "slim.amamou@gmail.com";
	}

	function testInsertEncryptsPersonalInfo()
	{
		global $USER;

		$USER = new User;
		$USER->user_key = "1234567890123456";
		$USER->password = "6543210987654321";
		$this->person->user_id= $USER->id;
		$this->person->insert();
	    $result = $this->db->query("select * from person where id='".$this->person->id."'");
		$person = $result->fetch();
		$this->assertEqual(md5($person['name']), "e43275f823f1e9064fa6d4a31def8a07"); //"Slim Amamou" AES encrypted with "1234567890123456"


	}
}
