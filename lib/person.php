<?php

	require_once "activerecord.php";

class Person
{
	static $table;
	public $id;

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

} Person::$table = new ActiveRecord("person", "Person");
