<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

class WebsitesController extends AppController {

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		$this->Auth->deny();
	}

	public function index() {
		$website = $this->Websites->newEntity();
		
		if ($this->request->is('post')) {
			$websitesTable = TableRegistry::get('Websites');
			$this->request->data['user_id'] = $this->Auth->user('id');
			$websitesTable->patchEntity($website, $this->request->data);
			if ($websitesTable->save($website)) {
				// Redirect to verify page
			}
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
}
