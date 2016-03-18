<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class TestDataTable extends Table {

	public function initialize(array $config) {
		$this->belongsTo('Tests', [
			'className' => 'Tests',
		]);
	}

}