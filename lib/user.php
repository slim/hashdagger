<?php
	require_once "person.php";

class User extends Person
{
    static $db;
    public $id;
    public $password;
    public $role;
    public $user_key;
	public $person_id;
    
    function __construct($id=NULL)
    {
    	if ($id) {
  			$this->id = $id;
  		} else {
  			$this->id = uniqid();
  		}
  		
  	  $this->password = NULL;
      $this->name = NULL;
      $this->mail = NULL;
      $this->role = NULL;
    }
    
    static function loadByCreator($id, $password)
	{
		$query = self::$db->prepare("select *, AES_DECRYPT(name, AES_DECRYPT(creator_key, :key_password)) as decrypted_name, AES_DECRYPT(mail, AES_DECRYPT(creator_key, :key_password)) as decrypted_mail, AES_DECRYPT(phone, AES_DECRYPT(creator_key, :key_password)) as decrypted_phone, AES_DECRYPT(creator_key, :key_password) AS decrypted_user_key from person where (login=:login)");
		$query->bindValue(':key_password', $password);
		$query->bindValue(':login', $id);
		$query->execute();
		$entry = $query->fetch();
		if (!$entry) return NULL;
		$user = new User($id);
		$user->person_id = $entry['id'];
		$user->getDBData($entry);
		$user->name = $entry['decrypted_name'];
		$user->user_key = $entry['decrypted_user_key'];
		$user->mail = $entry['decrypted_mail'];		          			
		$user->phone = $entry['decrypted_phone'];
  		return $user;
  	}

    static function load($id, $password)
  	{
		$query = self::$db->prepare("select *, AES_DECRYPT(name, AES_DECRYPT(user_key, :key_password)) as decrypted_name, AES_DECRYPT(mail, AES_DECRYPT(user_key, :key_password)) as decrypted_mail, AES_DECRYPT(phone, AES_DECRYPT(user_key, :key_password)) as decrypted_phone, AES_DECRYPT(user_key, :key_password) AS decrypted_user_key from person where (login=:login) and password=MD5(:password)");
		$query->bindValue(':key_password', $password);
		$query->bindValue(':password', $password);
		$query->bindValue(':login', $id);
		$query->execute();
		$entry = $query->fetch();
		if (!$entry) return NULL;
		$user = new User($id);
		$user->person_id = $entry['id'];
		$user->getDBData($entry);
		$user->password = $password;
		$user->name = $entry['decrypted_name'];
		$user->user_key = $entry['decrypted_user_key'];
		$user->mail = $entry['decrypted_mail'];		          			
		$user->phone = $entry['decrypted_phone'];
  		return $user;
  	}
  	
	public function changePassword($pass)
	{
		 $query = 'UPDATE person SET user_key=AES_ENCRYPT(:user_key, :new_password), password=:md5_password WHERE login=:id';
		 $query = self::$db->prepare($query);
		 $query->bindValue(':user_key', $this->user_key);
		 $query->bindValue(':new_password', $pass);
		 $query->bindValue(':md5_password', MD5($pass));
		 $query->bindValue(':id', $this->id);
		 $result = $query->execute();
		 $this->password = $pass;
		 return $this;
	}
        
	function generatePassword()
	{
		 $this->changePassword(substr(uniqid(), -5));
	}

	function countContacts()
	{
		$query = self::$db->prepare("select count(*) from person where user_id=:user_id");
		$query->bindValue(':user_id', $this->id);
		$query->execute();
		list($count) = $query->fetch();
		return $count;
	}

	static function httpAuth($role = NULL)
	{
		$login  = $_SERVER['PHP_AUTH_USER'];
		$password = $_SERVER['PHP_AUTH_PW'];

		if ($login && "nobody" != $login && $password) {
			$user = User::load($login, $password);
			$user->password = $password;
			if ($user instanceof User) {
				return $user;
			}
		}
		
		$realm = "Application";
		Header("WWW-Authenticate: Basic realm=\"$realm\"");
		Header("HTTP/1.0 401 Unauthorized");
		@include "unauthorized.html";
		die();
	}
}
