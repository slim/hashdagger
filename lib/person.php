<?php

require_once "activerecord.php";

class Person
{
	static $table;
	public $id;
	static $db;

	function __construct($id=null)
	{
		if($id) $this->id = $id;
	}

	function insert()
	{
		$this->id = uniqid();
		return self::$table->insert($this);		
	}
	
	function update()
	{
		$query = 'update person set';
		if($this->login && $this->password)
			$query.= ' login=:login, password=:password, is_user=:is_user,';
		$query.= ' user_id=:user_id, name=:name, age=:age, phone=:phone, mail=:mail, will_vote=:will_vote, for_party=:for_party, for_independent=:for_independent, opinion=:opinion, is_supporter=:is_supporter, is_volunteer=:is_volunteer, note=:note WHERE id=:id';
		$query = self::$db->prepare($query);
		$query->bindValue(':user_id', $this->user_id);
		if($this->login && $this->password)
		{
			$query->bindValue(':login', $this->login);
			$query->bindValue(':password', $this->password);
			$query->bindValue(':is_user', date('c'));
		}
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
		$person = self::$table->select("WHERE id='".$person_id."'");
		return $person[0];
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
		 $this->login = $this->mail;
		 $this->password = substr(uniqid(), -5);
		 $query = 'update person set';
		 
		 if($this->login && $this->password)
			$query.= ' login=:login, password=:password, is_user=:is_user';
		 $query .= ' WHERE id=:id';
		 
		 $query = self::$db->prepare($query);
		 $query->bindValue(':is_user', date('c'));
		 $query->bindValue(':login', $this->login);
		 $query->bindValue(':password', $this->password);
		 $query->bindValue(':id', $this->id);
		 $result = $query->execute();
	}
	
	static function selectByUser($user_id)
	{
		$persons = Array();
		$query = self::$db->prepare('select * from person where user_id=:user_id');
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
