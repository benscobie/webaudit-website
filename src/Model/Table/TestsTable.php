<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class TestsTable extends Table {

	public function initialize(array $config) {
		$this->belongsTo('Scans', [
			'className' => 'Scans',
		]);
		
		$this->hasMany('TestData', [
			'className' => 'TestData',
			'foreignKey' => 'test_id',
		]);
	}

}