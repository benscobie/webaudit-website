<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class WebsitesTable extends Table {

	public function validationDefault(Validator $validator) {

		$validator->add('hostname', 'custom', [
			'rule' => function ($value, $context) {
				// http://stackoverflow.com/a/4694816
				return (preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $value) //valid chars check
						&& preg_match("/^.{1,253}$/", $value) //overall length check
						&& preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $value)); //length of each label
			}
		]);

		return $validator;
	}

}
