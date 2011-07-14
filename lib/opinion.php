<?php

class Opinion
{
	static $db;
	public $id;
	public $person;

	function __construct($person)
	{
		$this->id = uniqid();
		$this->person = $person;
	}

	function insert()
	{
		$query = self::$db->prepare('insert into opinion (id, person_id, will_vote, for_party, for_independent, reason, is_supporter, is_volunteer, note) values (:id, :person_id, :will_vote, :for_party, :for_independent, :reason, :is_supporter, :is_volunteer, :note)');
		$query->bindValue(':id', $this->id);
		$query->bindValue(':person_id', $this->person->id);
		$query->bindValue(':will_vote', $this->will_vote);
		$query->bindValue(':for_party', $this->for_party);
		$query->bindValue(':for_independent', $this->for_independent);
		$query->bindValue(':reason', $this->reason);
		$query->bindValue(':is_supporter', $this->is_supporter);
		$query->bindValue(':is_volunteer', $this->is_volunteer);
		$query->bindValue(':note', $this->note);
		$query->execute();
	}

} 
