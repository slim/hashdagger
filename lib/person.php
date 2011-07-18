<?php

require_once "activerecord.php";

class Person
{
	static $table;
	public $id;
	static $db;

	function __construct()
	{
		$this->id = uniqid();
	}

	function insert()
	{
		return self::$table->insert($this);
	}
	
	function getData($data)
	{
		$this->name  = $data['person-name'];
		$this->age   = $data['person-age'];
		$this->phone = $data['person-phone'];
		$this->mail  = $data['person-mail'];
			
		if ($data['will-vote']) $this->will_vote = date("c");
		if ($data['for-party']) $this->for_party = date("c");
		if ($data['for-independent']) $this->for_independent = date("c");
		$this->opinion = $data['reason'];
		if ($data['supporter']) $this->is_supporter = date("c");
		if ($data['volunteer']) $this->is_volunteer = date("c");
		$this->note = $data['note'];
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
	   		$persons [] = $person;   
	    }
	    
	    return $persons;
	}

} Person::$table = new ActiveRecord("person", "Person");
