<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class HelpController extends AppController {

	public function initialize() {
		parent::initialize();
	}

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		$this->Auth->deny();
	}
	
	public function ssl() {
		$this->autoRender = false;
	}
	
	public function headers() {
		$this->autoRender = false;
	}


}
