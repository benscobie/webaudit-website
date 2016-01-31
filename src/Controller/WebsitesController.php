<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class WebsitesController extends AppController {

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		$this->Auth->deny();
	}

	public function index() {
		$website = $this->Websites->newEntity();
		
		if ($this->request->is('put')) {
			$websitesTable = TableRegistry::get('Websites');
			
		}
		
		$this->set(compact('website'));
		$this->set('websites', $this->Websites->find('all'));
	}
	
	public function verify($id) {
		
	}
	
	public function view($id) {
		$website = $this->Websites->get($id);
		$this->set(compact('website'));
	}

	public function add() {
		
	}

}
