<?php

class Person
{
	public $id;
	static $db;
	public $name;
	public $age;
	public $phone;
	public $mail;
	public $will_vote;
	public $for_party;
	public $for_independent;
	public $opinion;
	public $is_supporter;
	public $is_volunteer;
	public $note;
	public $is_user;
	   

	function __construct($id=null)
	{
		if($id) $this->id = $id;
	}

	function insert()
	{
		$this->id = uniqid();
		
		global $USER;
		
		$query = self::$db->prepare("insert person set id=:id, user_id=:user_id, name=AES_ENCRYPT(:name, :name_key), age=:age, phone=AES_ENCRYPT(:phone, :phone_key), phone_signature=MD5(:phone), mail=AES_ENCRYPT(:mail, :mail_key), mail_signature=MD5(:mail), will_vote=:will_vote, for_party=:for_party, for_independent=:for_independent, opinion=:opinion, is_supporter=:is_supporter, is_volunteer=:is_volunteer, note=:note");
		$query->bindValue(':name_key', $USER->user_key);
		$query->bindValue(':mail_key', $USER->user_key);
		$query->bindValue(':phone_key', $USER->user_key);
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

        $query->execute();
		return $query;
	}
	
	function update()
	{
		global $USER;
		
		$query = "update person set"; 
		$query.= " name=IF(is_user is null, AES_ENCRYPT(:name, :name_key), AES_ENCRYPT(:name2, AES_DECRYPT(creator_key, :name_password)))";
		$query.= ", age=:age, phone_signature=MD5(:phone), mail_signature=MD5(:mail)";
		$query.= ", phone=IF(is_user is null, AES_ENCRYPT(:phone, :phone_key), AES_ENCRYPT(:phone2, AES_DECRYPT(creator_key, :phone_password)))";
		$query.= ", mail=IF(is_user is null , AES_ENCRYPT(:mail, :mail_key), AES_ENCRYPT(:mail2, AES_DECRYPT(creator_key, :mail_password)))";
		$query.= ", will_vote=:will_vote, for_party=:for_party, for_independent=:for_independent, opinion=:opinion, is_supporter=:is_supporter, is_volunteer=:is_volunteer, note=:note WHERE id=:id";
		$query = self::$db->prepare($query);
		
		$query->bindValue(':name_key', $USER->user_key);
		$query->bindValue(':mail_key', $USER->user_key);
		$query->bindValue(':phone_key', $USER->user_key);
		$query->bindValue(':name_password', $USER->password);
		$query->bindValue(':mail_password', $USER->password);
		$query->bindValue(':phone_password', $USER->password);
		$query->bindValue(':name', $this->name);
		$query->bindValue(':name2', $this->name);
		$query->bindValue(':age', $this->age);
		$query->bindValue(':phone', $this->phone);
		$query->bindValue(':mail', $this->mail);
		$query->bindValue(':phone2', $this->phone);
		$query->bindValue(':mail2', $this->mail);
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
	
	static function count()
	{
		list($count) = self::$db->query("select count(*) from person")->fetch();
		return $count;
	}

	static function selectById($person_id)
	{		
		global $USER;
		
		if($USER->person_id == $person_id) return $USER;

		$query = 'select id, login, age';
		$query.= ', IF(is_user is null, AES_DECRYPT(name, :user_key), AES_DECRYPT(name, AES_DECRYPT(creator_key, :user_password))) AS name';		
		$query.= ', IF(is_user is null, AES_DECRYPT(phone, :user_key1), AES_DECRYPT(phone, AES_DECRYPT(creator_key, :user_password2))) AS phone';
		$query.= ', IF(is_user is null, AES_DECRYPT(mail, :user_key2), AES_DECRYPT(mail, AES_DECRYPT(creator_key, :user_password3))) AS mail';
		$query.= ', will_vote, for_party, for_independent, opinion, is_supporter, is_volunteer, note, is_user';
		$query.= ' from person where id=:id';
		$query.= ' AND user_id = :user_id';
		
		$query = self::$db->prepare($query);
		
		$query->bindValue(':user_key', $USER->user_key);
		$query->bindValue(':user_key1', $USER->user_key);
		$query->bindValue(':user_key2', $USER->user_key);
		$query->bindValue(':id', $person_id);
		$query->bindValue(':user_id', $USER->id);
		$query->bindValue(':user_password', $USER->password);
		$query->bindValue(':user_password2', $USER->password);
		$query->bindValue(':user_password3', $USER->password);
		
      	$result = $query->execute();
      	
		$entry = $query->fetch();
   		$person = new Person($entry['id']);
		$person->getDBData($entry);
	   
		return $person;
	}

	function getDBData($entry)
	{
		$this->name = $entry['name'];
		$this->age = $entry['age'];
		$this->phone = $entry['phone'];
		$this->mail = $entry['mail'];
		$this->will_vote = $entry['will_vote'];
		$this->for_party = $entry['for_party'];
		$this->for_independent = $entry['for_independent'];
		$this->opinion = $entry['opinion'];
		$this->is_supporter = $entry['is_supporter'];
		$this->is_volunteer = $entry['is_volunteer'];
		$this->note = $entry['note'];
		$this->is_user = $entry['is_user'];
	}
	
	function getData($data)
	{
		$this->name  = $data['person-name'];
		$this->age   = $data['person-age'];
		$this->phone = $data['phone'];
		$this->mail  = $data['mail'];
			
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

		 $login = $this->mail;
		 $password = substr(uniqid(), -5);
		 $this->user_key = substr(uniqid(), -16);
		 
		 $query = 'update person set login=:login, password=:password, is_user=:is_user, user_key=AES_ENCRYPT(:user_key, :user_password), creator_key=AES_ENCRYPT(:user_key, :creator_password), name=AES_ENCRYPT(:name, :user_key), phone=AES_ENCRYPT(:phone, :user_key), mail=AES_ENCRYPT(:mail, :user_key) WHERE id=:id';
		 
		 $query = self::$db->prepare($query);
		 $query->bindValue(':is_user', date('c'));
		 $query->bindValue(':login', $login);
		 $query->bindValue(':password', MD5($password));
		 $query->bindValue(':user_key', $this->user_key);
		 $query->bindValue(':user_password', $password);
		 $query->bindValue(':creator_password', $USER->password);
		 $query->bindValue(':name', $this->name);
		 $query->bindValue(':phone', $this->phone);
		 $query->bindValue(':mail', $this->mail);
		 $query->bindValue(':id', $this->id);
		 $result = $query->execute();

		 $user = User::load($login, $password);
		 return $user;
	}
	
	static function selectByUser($user_id)
	{
		global $USER;
		
		$persons = Array();
		$query = 'select id';
		$query.= ', IF(is_user is null, AES_DECRYPT(name, :user_key), AES_DECRYPT(name, AES_DECRYPT(creator_key, :user_password))) AS name';
		$query.= ', age';
		$query.= ', IF(is_user is null, AES_DECRYPT(phone, :user_key1), AES_DECRYPT(phone, AES_DECRYPT(creator_key, :user_password2))) AS phone';
		$query.= ', IF(is_user is null, AES_DECRYPT(mail, :user_key2), AES_DECRYPT(mail, AES_DECRYPT(creator_key, :user_password3))) AS mail';
		$query.= ', will_vote, for_party, for_independent, opinion, is_supporter, is_volunteer, note, is_user';
		$query.= ' from person where user_id=:user_id';
		
		$query = self::$db->prepare($query);
		$query->bindValue(':user_key', $USER->user_key);
		$query->bindValue(':user_key1', $USER->user_key);
		$query->bindValue(':user_key2', $USER->user_key);
		$query->bindValue(':user_password', $USER->password);
		$query->bindValue(':user_password2', $USER->password);
		$query->bindValue(':user_password3', $USER->password);
		$query->bindValue(':user_id', $user_id);		
      	$result = $query->execute();
      	
		foreach ($query->fetchAll() as $entry) {
			$person = new Person($entry['id']);
			$person->getDBData($entry);
	   		$persons [] = $person;   
	    }
	    
	    return $persons;
	}

	function exist()
	{
		global $USER;
		
		$persons = Array();
		$query = 'select count(id) AS exist FROM person WHERE';
		$query.= ' (phone_signature = MD5(:phone)';
		$query.= ' OR mail_signature = MD5(:mail))';
		
		if($this->id)
			$query.= ' AND id != :id';
		$query = self::$db->prepare($query);
		$query->bindValue(':phone', $this->phone);
		$query->bindValue(':mail', $this->mail);
		if($this->id) $query->bindValue(':id', $this->id);

      	$result = $query->execute();
      
		if($entry['exist']) return true;
		else return false;	
	}
	
	function existPhone()
	{
		global $USER;
		
		$persons = Array();
		$query = 'select count(id) AS exist FROM person WHERE';
		$query.= ' phone_signature = MD5(:phone)';
		if($this->id)
			$query.= ' AND id != :id';
			
		$query = self::$db->prepare($query);
		
		$query->bindValue(':phone', $this->phone);
		if($this->id) $query->bindValue(':id', $this->id);
		
      	$result = $query->execute();
      	
		$entry = $query->fetch();
		if($entry['exist']) return true;
		else return false;	
	}
	
	function existMail()
	{
		global $USER;
		
		$persons = Array();
		$query = 'select count(id) AS exist FROM person WHERE';
		$query.= ' mail_signature = MD5(:mail)';
		if($this->id)
			$query.= ' AND id != :id';
			
		$query = self::$db->prepare($query);
		
		$query->bindValue(':mail', $this->mail);
		if($this->id) $query->bindValue(':id', $this->id);
		
      	$result = $query->execute();
      	
		$entry = $query->fetch();
		if($entry['exist']) return true;
		else return false;	
	}
	
}

