<?php
	require_once "../../lib/simpletest/autorun.php";
	require_once "../../lib/person.php";
	require_once "../../lib/user.php";

		$DB = new PDO("mysql:host=localhost;dbname=hashdagger_test", "root");
		$DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		Person::$db = $DB;
		User::$db = $DB;

	$DB->query("delete from person");
	$USER = new User;
	$USER->user_key = "1234567890123456";
	$USER->password = "6543210987654321";
	$PERSON = new Person;
	$PERSON->name = "Slim Amamou";
	$PERSON->age = "33";
	$PERSON->phone = "555888888";
	$PERSON->mail = "slim.amamou@gmail.com";
	$PERSON->user_id= $USER->id;
	$PERSON->insert();
	$U = $PERSON->becomeUser();

class TestOfUser extends UnitTestCase {
	function setUp()
	{
		global $DB;

		$this->db = $DB;
	}

	function testLoad()
	{
		global $USER, $PERSON, $U;

		$user = User::load($U->id, $U->password);
		$this->assertEqual($user->name, "Slim Amamou");
		$this->assertEqual($user->age, "33");
		$this->assertEqual($user->phone, "555888888");

		$user = User::loadByCreator($U->id, $USER->password);
		$this->assertEqual($user->name, "Slim Amamou");
		$this->assertEqual($user->age, "33");
		$this->assertEqual($user->phone, "555888888");
	}

	function testChangePassword()
	{
		global $USER, $PERSON, $U;

		$person_id = $U->id;
		$old_password = $U->password;
	    $result = $this->db->query("select aes_decrypt(user_key, '$old_password') as user_key from person where login='$person_id'");
		$p = $result->fetch();
		$old_key = $p['user_key'];

		$U->changePassword("1111"); // current user changing password of another user
		$this->assertEqual($U->password, "1111");
	    $result = $this->db->query("select password, aes_decrypt(user_key, '1111') as user_key from person where login='$person_id'");
		$p = $result->fetch();
		$new_key = $p['user_key'];
		$this->assertEqual($new_key, $old_key);
		$this->assertEqual($p['password'], md5('1111'));

		$USER = $U;
		$user_key = $USER->user_key;
		$USER->changePassword("2222"); // current user changing his password
		$this->assertEqual($USER->password, "2222");
		$person_id = $USER->id;
	    $result = $this->db->query("select password, aes_decrypt(user_key, '2222') as user_key from person where login='$person_id'");
		$p = $result->fetch();
		$this->assertEqual($p['user_key'], $user_key);
		$this->assertEqual($p['password'], md5('2222'));
	}

	function testGeneratePassword()
	{
		global $USER;

		$USER->generatePassword();
		$person_id = $USER->id;
	    $result = $this->db->query("select password from person where login='$person_id'");
		$p = $result->fetch();
		$this->assertEqual($p['password'], md5($USER->password));
	}
}
