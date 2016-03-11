<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Scan extends Entity {

	// Make all fields mass assignable except for primary key field "id".
	protected $_accessible = [
		'*' => true,
		'id' => false
	];
	
	public function getStatusMessage() {
		$statusMap = [
			0 => "Queued",
			1 => "In Progress",
			2 => "Completed",
			3 => "Cancelled",
			4 => "Error"
		];
		
		return $statusMap[$this->status];
	}

}
