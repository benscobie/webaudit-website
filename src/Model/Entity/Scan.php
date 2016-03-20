<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

class Scan extends Entity {

	// Make all fields mass assignable except for primary key field "id".
	protected $_accessible = [
		'*' => true,
		'id' => false
	];
	
	const STATUS_QUEUED = 0;
	const STATUS_IN_PROGRESS = 1;
	const STATUS_COMPLETED = 2;
	const STATUS_CANCELLED = 3;
	const STATUS_ERROR = 4;
	
	const STATUS_MAP = [
		self::STATUS_QUEUED => "Queued",
		self::STATUS_IN_PROGRESS => "In Progress",
		self::STATUS_COMPLETED => "Completed",
		self::STATUS_CANCELLED => "Cancelled",
		self::STATUS_ERROR => "Error"
	];

	public function getStatusMessage() {
		return (self::STATUS_MAP[$this->status]);
	}
	
	public function queuePosition() {
		if ($this->status == Scan::STATUS_QUEUED) {
			$scansTable = TableRegistry::get('Scans');
			$scansQueued = $scansTable->find('all', [
				'order' => ['Scans.created_date' => 'ASC'],
				'conditions' => ['Scans.status =' => Scan::STATUS_QUEUED]
			]);
			
			$queuePos = 0;
			foreach ($scansQueued as $scan) {
				$queuePos++;
				if ($scan['id'] == $this->id) {
					return $queuePos;
				}
			}
			
			return 0;
		} else {
			return 0;
		}
	}
	
	public static function getActiveScanForWebsite( $websiteID ) {
		$scansTable = TableRegistry::get('Scans');
		
		$query = $scansTable->find('all')
			->where([
				'Scans.website_id =' => $websiteID,
				'OR' => [
					['Scans.status =' => self::STATUS_IN_PROGRESS],
					['Scans.status =' => self::STATUS_QUEUED],
				]
			]);
		
		$scan = $query->first();
		return $scan;
	}

}