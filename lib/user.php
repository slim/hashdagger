<?php

class User
{
    static $db;
    public $id;
    public $password;
    public $role;
    public $name;
    public $email;
    
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
  		$query = "select * from users $options";
  		return $query;
  	}

  	public function toSQLinsert()
  	{
  	  $id = $this->id;
  	  $password = $this->password;
      $name = $this->name;
      $email = $this->email;
      
      return "insert into users (id, pass, name, email) values ('$id', '$password', '$name', '$email')";
  	}
  	
  	public static function select($options = NULL)
	{
	   $query = self::sql_select($options);
	   $result = self::$db->query($query);
	   $users = array();
	   	foreach ($result as $entry) {
	   		$user = new User($entry['id']);
	   		$user->password = $entry['pass'];
       		$user->name = $entry['designation'];
			if ($entry['role']) {
       			$user->role = $entry['role'];
			}
       		$user->email = $entry['email'];

	   		$users [] = $user;   
	    }        
	    return $users;
    }
    
    static function load($id, $password = NULL)
  	{
		if ($password) {
			list($user) = self::select("where (code='$id' or email='$id' or id='$id') and pass='$password'");
		}
		else {
			list($user) = self::select("where id='$id'");
		}
  		return $user;
  	}
  	
	public function changePassword($pass)
	{
		$id = "'".$this->id."'";
		$pass = "'$pass'";
		$query = "update users set pass=$pass where id=$id";
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
		$query = "select * from users where id='$id' and pass='$password'";
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
		$passwd = $_SERVER['PHP_AUTH_PW'];

		if ($login && "nobody" != $login && $passwd) {
			$user = User::load($login, $passwd);
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
