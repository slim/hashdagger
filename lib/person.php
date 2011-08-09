<?php

require_once "activerecord.php";

class Person
{
	static $table;
	public $id;
	static $db;
	public $user_key;

	function __construct($id=null)
	{
		if($id) $this->id = $id;
	}

	function insert()
	{
		$this->id = uniqid();
		
		global $USER;
		
		$query = "insert person set";
		$query.= " id=:id, user_id=:user_id, name=AES_ENCRYPT(:name, '".$USER->user_key."'), age=:age, phone=AES_ENCRYPT(:phone, '".$USER->user_key."'), mail=AES_ENCRYPT(:mail, '".$USER->user_key."'), will_vote=:will_vote, for_party=:for_party, for_independent=:for_independent, opinion=:opinion, is_supporter=:is_supporter, is_volunteer=:is_volunteer, note=:note";
		$query = self::$db->prepare($query);
		$query->bindValue(':user_id', $this->user_id);
		
		$query->bindValue(':name', $this->name);
		$query->bindValue(':age', $this->age);
		$query->bindValue(':phone', $this->phone);
		$query->bindValue(':mail', $this->mail);
		$query->bindValue(':will_vote', $this->will_vote);
		$query->bindValue(':for_party', $this->for_party);
		$query->bindValue(':for_independent', $this->for_independent);
		$query->bindValue(':opinion', $this->opinion);
		$query->bindValue(':is_supporter', $this->is_supporter);
		$query->bindValue(':is_volunteer', $this->is_volunteer);
		$query->bindValue(':note', $this->note);
		$query->bindValue(':id', $this->id);

      	return $result = $query->execute();
	}
	
	function update()
	{
		global $USER;
		
		$query = "update person set";
		$query.= " name=AES_ENCRYPT(:name, '".$USER->user_key."'), age=:age, phone=AES_ENCRYPT(:phone, '".$USER->user_key."'), mail=AES_ENCRYPT(:mail, '".$USER->user_key."'), will_vote=:will_vote, for_party=:for_party, for_independent=:for_independent, opinion=:opinion, is_supporter=:is_supporter, is_volunteer=:is_volunteer, note=:note WHERE id=:id";
		$query = self::$db->prepare($query);
		
		$query->bindValue(':name', $this->name);
		$query->bindValue(':age', $this->age);
		$query->bindValue(':phone', $this->phone);
		$query->bindValue(':mail', $this->mail);
		$query->bindValue(':will_vote', $this->will_vote);
		$query->bindValue(':for_party', $this->for_party);
		$query->bindValue(':for_independent', $this->for_independent);
		$query->bindValue(':opinion', $this->opinion);
		$query->bindValue(':is_supporter', $this->is_supporter);
		$query->bindValue(':is_volunteer', $this->is_volunteer);
		$query->bindValue(':note', $this->note);
		$query->bindValue(':id', $this->id);

      	$result = $query->execute();
      	
	}
	
	static function selectById($person_id)
	{		
		global $USER;
		
		$persons = Array();
		$query = 'select id, AES_DECRYPT(name, :user_key) AS name, age, AES_DECRYPT(phone, :user_key1) AS phone';
		$query.= ', AES_DECRYPT(mail, :user_key2) AS mail, will_vote, for_party, for_independent, opinion, is_supporter, is_volunteer, note, is_user';
		$query.= ' from person where id=:id AND user_id = :user_id';
		
		$query = self::$db->prepare($query);
		$query->bindValue(':user_key', $USER->user_key);
		$query->bindValue(':user_key1', $USER->user_key);
		$query->bindValue(':user_key2', $USER->user_key);
		$query->bindValue(':id', $person_id);
		$query->bindValue(':user_id', $USER->id);
      	$result = $query->execute();
      	
		$entry = $query->fetch();
   		$person = new Person();
		$person->id = $entry['id'];
		$person->name = $entry['name'];
		$person->age = $entry['age'];
		$person->phone = $entry['phone'];
		$person->mail = $entry['mail'];
		$person->will_vote = $entry['will_vote'];
		$person->for_party = $entry['for_party'];
		$person->for_independent = $entry['for_independent'];
		$person->opinion = $entry['opinion'];
		$person->is_supporter = $entry['is_supporter'];
		$person->is_volunteer = $entry['is_volunteer'];
		$person->note = $entry['note'];
		$person->is_user = $entry['is_user'];
	   	    
	    return $person;
	}
	
	function getData($data)
	{
		$this->name  = $data['person-name'];
		$this->age   = $data['person-age'];
		$this->phone = $data['phone'];
		$this->mail  = $data['email'];
			
		if ($data['will-vote']) $this->will_vote = date("c"); else $this->will_vote = null;
		if ($data['for-party']) $this->for_party = date("c"); else $this->for_party = null;
		if ($data['for-independent']) $this->for_independent = date("c"); else $this->for_independent = null;
		$this->opinion = $data['reason'];
		if ($data['supporter']) $this->is_supporter = date("c"); else $this->is_supporter = null;
		if ($data['volunteer']) $this->is_volunteer = date("c"); else $this->is_volunteer = null;
		$this->note = $data['note'];
		if ($data["login"] && $data["password"]) 
		{
			$this->is_user = date("c");
			$this->login = $data["login"];
			$this->password = MD5($data["password"]);
		}
		else
			$this->is_user = null;
		
		if ($data['person_id']) $this->id = $data["person_id"];
	}
	
	function becomeUser()
	{
		 global $USER;
		 $this->login = $this->mail;
		 $this->password = substr(uniqid(), -5);
		 $this->user_key = substr(uniqid(), -16);
		 $query = 'update person set';
		 
		 if($this->login && $this->password)
			$query.= ' login=:login, password=:password, is_user=:is_user, user_key=AES_ENCRYPT(:user_key, :user_password), creator_key=AES_ENCRYPT(:user_key2, :creator_password)';
		 $query .= ' WHERE id=:id';
		 
		 $query = self::$db->prepare($query);
		 $query->bindValue(':is_user', date('c'));
		 $query->bindValue(':login', $this->login);
		 $query->bindValue(':password', MD5($this->password));
		 $query->bindValue(':user_key', $this->user_key);
		 $query->bindValue(':user_key2', $this->user_key);
		 $query->bindValue(':user_password', $this->password);
		 $query->bindValue(':creator_password', $USER->password);
		 $query->bindValue(':id', $this->id);
		 $result = $query->execute();
	}
	
	function updatePassword()
	{
		 global $USER;
		 $query = 'UPDATE person SET user_key=AES_ENCRYPT(AES_DECRYPT(creator_key, :creator_password), :user_password), password=:user_password2 WHERE id=:id';
		 $query = self::$db->prepare($query);
		 $query->bindValue(':creator_password', $USER->password);
		 $query->bindValue(':user_password', $this->password);
		 $query->bindValue(':user_password2', MD5($this->password));
		 $query->bindValue(':id', $this->id);
		 $result = $query->execute();
	}
	
	function generatePassword()
	{
		 $this->password = substr(uniqid(), -5);
		 $this->updatePassword();
	}
	
	static function selectByUser($user_id)
	{
		global $USER;
		
		$persons = Array();
		$query = 'select id, AES_DECRYPT(name, :user_key) AS name, age, AES_DECRYPT(phone, :user_key1) AS phone';
		$query.= ', AES_DECRYPT(mail, :user_key2) AS mail, will_vote, for_party, for_independent, opinion, is_supporter, is_volunteer, note, is_user';
		$query.= ' from person where user_id=:user_id';
		
		$query = self::$db->prepare($query);
		$query->bindValue(':user_key', $USER->user_key);
		$query->bindValue(':user_key1', $USER->user_key);
		$query->bindValue(':user_key2', $USER->user_key);
		$query->bindValue(':user_id', $user_id);		
      	$result = $query->execute();
      	
		foreach ($query->fetchAll() as $entry) {
	   		$person = new Person();   		
			$person->id = $entry['id'];
			$person->name = $entry['name'];
			$person->age = $entry['age'];
			$person->phone = $entry['phone'];
			$person->mail = $entry['mail'];
			$person->will_vote = $entry['will_vote'];
			$person->for_party = $entry['for_party'];
			$person->for_independent = $entry['for_independent'];
			$person->opinion = $entry['opinion'];
			$person->is_supporter = $entry['is_supporter'];
			$person->is_volunteer = $entry['is_volunteer'];
			$person->note = $entry['note'];
			$person->is_user = $entry['is_user'];
	   		$persons [] = $person;   
	    }
	    
	    return $persons;
	}

} Person::$table = new ActiveRecord("person", "Person");
