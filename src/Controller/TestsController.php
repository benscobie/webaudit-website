<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Network\Exception\UnauthorizedException;

class TestsController extends AppController {
	
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		$this->Auth->deny();
	}
	
	public function view($id) {
		if ($this->request->is('ajax')) {
			$this->response->disableCache();
			$this->autoRender = false;

			$test = $this->Tests->get($id, [
				'contain' => ['Scans' => ['Websites'], 'TestData']
			]);

			if ($test['scan']['website']['user_id'] != $this->Auth->user('id')) {
				throw new UnauthorizedException(__('Unauthorised'));
			}
			$this->set(compact('test'));
			
			$this->render('/Layout/Tests/' . strtolower($test['name']), false);
		} else {
			throw new NotFoundException();
		}
	}
}
