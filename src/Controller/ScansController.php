<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class ScansController extends AppController {

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		$this->Auth->deny();
	}

	public function index() {
		$this->set('scans', $this->Scans->find('all', ['contain' => ['Websites']]));
	}

	public function view($id) {
		$scan = $this->Scans->get($id);
		$this->set(compact('scan'));
	}

	public function add() {
		
	}

}
