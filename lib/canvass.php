<?php

class Canvass
{
	static $db;

	public $id;
	public $user_id;
	public $volunteer_id;
	public $begin;
	public $end;
	public $opened_door;
	public $answered_questions;

	function __construct()
	{
		$this->id = uniqid();		
	}

	function insert()
	{
		$query = self::$db->prepare('insert into canvass (id, user_id, volunteer_id, begin, end, opened_door, answered_questions, place_id) values (:id, :user_id, :volunteer_id, :begin, :end, :opened_door, :answered_questions, :place_id)');
		$query->bindValue(':id', $this->id);
		$query->bindValue(':user_id', $this->user_id);
		$query->bindValue(':volunteer_id', $this->volunteer_id);
		$query->bindValue(':begin', $this->begin);
		$query->bindValue(':end', $this->end);
		$query->bindValue(':opened_door', $this->opened_door);
		$query->bindValue(':answered_questions', $this->answered_questions);
		$query->bindValue(':place_id', $this->place->id);
		$query->execute();
	}

	function talkedTo($person)
	{
		$query = self::$db->prepare("update canvass set person_id=:person_id where id=:id");
		$query->bindValue(':id', $this->id);
		$query->bindValue(':person_id', $person->id);
		$query->execute();
	}
	
	function getData($data)
	{
		$this->begin = $data['canvass-begin']; 
		$this->end   = $data['canvass-end']; 
		if (!$data['door-closed']) $this->opened_door = date("c");
		if ($data['answered-questions']) $this->answered_questions = date("c");
		$this->address_region   = $data['region'];
		$this->address_district = $data['district'];
		$this->address_street   = $data['street'];
		$this->address_building = $data['building-num'];
		$this->address_level	= $data['level-num'];
		$this->address_house    = $_POST['house-num'];
	}

} 
