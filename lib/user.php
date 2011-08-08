<?php

class User
{
    static $db;
    public $id;
    public $password;
    public $role;
    public $name;
    public $email;
    public $user_key;
    
    function __construct($id=NULL)
    {
    	if ($id) {
  			$this->id = $id;
  		} else {
  			$this->id = uniqid();
  		}
  		
  	  $this->password = NULL;
      $this->name = NULL;
      $this->email = NULL;
      $this->role = NULL;
    }
    
    static function set_db($db, $user = NULL, $password = NULL)
    {
    		if ($db instanceof PDO) {
    			self::$db =& $db;
    		} else {
    			if (empty($user)) {
    				self::$db =& new PDO($db);
    			} else {
    				self::$db =& new PDO($db, $user, $password);
    			}
    		}
    		self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    		return self::$db;
    }
    
    public static function sql_select($options = NULL)
  	{
  		$query = "select * from person $options";
  		return $query;
  	}

  	
  	public static function select($options = NULL)
	{
	   $query = self::sql_select($options);	   
	   $result = self::$db->query($query);
	   $users = array();
	   	foreach ($result as $entry) {
	   		$user = new User($entry['id']);
	   		$user->login = $entry['login'];
	   		$user->password = $entry['password'];
       		$user->name = $entry['name'];
			if ($entry['role']) {
       			$user->role = $entry['role'];
			}
       		$user->email = $entry['mail'];

	   		$users [] = $user;   
	    }        
	    return $users;
    }

    
    
    static function load($id, $password = NULL)
  	{
		if ($password) {
			$query = "select id, login, password, name, mail, AES_DECRYPT(user_key, '".$password."') AS user_key from person where (login='$login') and password='".MD5($password)."'";   
		    $result = self::$db->query($query);
		    $entry = $result->fetch();
			if (!$entry) return NULL;
	   		$user = new User($entry['id']);
	   		$user->login = $entry['login'];
       		$user->name = $entry['name'];
       		$user->user_key = $entry['user_key'];
			if ($entry['role']) {
       			$user->role = $entry['role'];
			}
       		$user->email = $entry['mail'];		          			
			
		}
		else {
			list($user) = self::select("where login='$id'");
		}
  		return $user;
  	}
  	
	public function changePassword($pass)
	{
		$id = "'".$this->id."'";
		$pass = "'$pass'";
		$query = "update person set password=$pass where login=$id";
		self::$db->exec($query);
	}
        
    public function save()		
    {
      $query = $this->toSQLinsert();
      self::$db->exec($query);
      return $this;		   
    }
        
	function isAuthentic()
	{
		$id = $this->id;
		$password = $this->password;
		$query = "select login from person where login='$id' and password='".MD5($password)."'";
      	$result = self::$db->query($query);
		if (!$result->fetch()) {
			return false;
		}
		else {
			return true;
		}
	}
	
	function isOneOf($roles)
	{
		if (!is_array($roles)) {
			$roles = array($roles);
		}
		foreach ($roles as $r) {
			if ($this->role == $r) return true;
		}
		return false;
	}

	static function httpAuth($role = NULL)
	{
		$login  = $_SERVER['PHP_AUTH_USER'];
		$password = $_SERVER['PHP_AUTH_PW'];

		if ($login && "nobody" != $login && $password) {
			$user = User::load($login, $passwd);
			$user->password = $password;
			if ($user instanceof User && $user->isOneOf($role)) {
				return $user;
			}
		}
		$realm = "Application";
		Header("WWW-Authenticate: Basic realm=\"$realm\"");
		Header("HTTP/1.0 401 Unauthorized");
		@include "unauthorized.html";
		die();
	}

	static function sessionAuth($role = NULL)
	{
		global $conf;
		
		$login_url = $conf['url_login'];
		$here = "http://". $_SERVER['SERVER_NAME'] ."/". $_SERVER['REQUEST_URI'];
		if ($_SESSION['user_id']) {
			$user = User::load($_SESSION['user_id']);
			if ($user instanceof User && $user->isOneOf($role)) {
				return $user;
			}
		}
		header("Location: $login_url?c=$here", 302);die();
	}
     	
}
