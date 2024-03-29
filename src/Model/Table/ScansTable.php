<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ScansTable extends Table {

	public function initialize(array $config) {
		$this->belongsTo('Websites', [
			'className' => 'Websites',
		]);
		
		$this->hasMany('Tests', [
			'className' => 'Tests',
			'foreignKey' => 'scan_id',
		]);
	}

}