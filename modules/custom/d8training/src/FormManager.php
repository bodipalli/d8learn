<?php 

namespace Drupal\d8training;

use Drupal\Core\Database\Driver\mysql\Connection;

class FormManager {
	
	private $connection;
  
	public function __construct( Connection $connection ){
		$this->connection = $connection;
	}

	public function fetchData() {
    $sel = $this->connection->select('my_from', 'fd');
    $sel->fields('fd', array());
    $sel->range(0, 1);
    $rs = $sel->execute()->fetchAssoc();
    return $rs;
	}

/*
SELECT `first_name`, `last_name` FROM `my_from` 
*/
	public function addData( $table, $data ) {
 // $first_name, $last_name;

		$result = $this->connection->insert($table) 
      ->fields ( array(
      'first_name' => $data['first_name'],
      'last_name' => $data['last_name'],
    ))->execute();
	}
}