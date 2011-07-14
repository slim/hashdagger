<?php

	require_once "activerecord.php";

class Place
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

} Place::$table = new ActiveRecord("place", "Place");
