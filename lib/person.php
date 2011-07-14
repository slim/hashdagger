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

} Person::$table = new ActiveRecord("person", "Person");
