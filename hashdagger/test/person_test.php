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
	$USER->name = "Anonymous";
	$USER->user_key = "1234567890123456";
	$USER->password = "6543210987654321";
	$PERSON = new Person;
	$PERSON->name = "Slim Amamou";
	$PERSON->mail = "slim.amamou@gmail.com";
	$PERSON->user_id= $USER->id;

class TestOfPerson extends UnitTestCase {
	function setUp()
	{
		global $DB;

		$this->db = $DB;
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
		$this->assertNotNull($p->id);
		$this->assertEqual($p->name, "Slim Amamou");

		list($p) = Person::selectByUser($PERSON->user_id);
		$this->assertNotNull($p->id);
		$this->assertEqual($p->name, "Slim Amamou");

	}

	function testSelectMyself()
	{
		global $USER;

		$p = Person::selectById($USER->person_id);
		$this->assertIsA($p, 'User');
		$this->assertEqual($p->id, $USER->id);
		$this->assertNotNull($p->name);

	}

	function testUpdate()
	{
		global $USER, $PERSON;

		$PERSON->name = "Anis Chaabani";
		$PERSON->update();
	    $result = $this->db->query("select * from person where id='".$PERSON->id."'");
		$p = $result->fetch();
		$this->assertEqual(md5($p['name']), "b8a0d847725567ef4886a5e7f584f726"); //"Anis Chaabani" AES encrypted with "1234567890123456"

	}

	function testBecomeUser()
	{
		global $USER, $PERSON;

		$u = $PERSON->becomeUser();
		$this->assertNotNull($u->password); 
		$this->assertEqual($u->person_id, $PERSON->id);

		$creator_password = $USER->password;
		$user_password = $u->password;
		$person_id = $PERSON->id;
	    $result = $this->db->query("select is_user, login, aes_decrypt(user_key, '$user_password') as user_key, aes_decrypt(creator_key, '$creator_password') as creator_key from person where id='$person_id'");
		$p = $result->fetch();
		$this->assertNotNull($p['is_user']); 
		$this->assertEqual($p['login'], "slim.amamou@gmail.com"); 
		$this->assertEqual($p['creator_key'], $p['user_key']);
		$key = $p['user_key'];
	    $result = $this->db->query("select aes_decrypt(name, '$key') as name from person where id='$person_id'");
		$p = $result->fetch();
		$this->assertEqual($p['name'], "Anis Chaabani"); 
	}

}
