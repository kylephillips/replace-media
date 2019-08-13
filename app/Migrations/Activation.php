<?php 
namespace ReplaceMedia\Migrations;

use ReplaceMedia\Migrations\CreateTables;

/**
* Plugin Activation
*/
class Activation 
{
	public function __construct()
	{
		$this->migrateTables();
	}

	/**
	* Table Migration
	*/
	private function migrateTables()
	{
		new CreateTables;
	}
}