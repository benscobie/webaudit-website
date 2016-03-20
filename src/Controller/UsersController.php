<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Core\Configure;

class UsersController extends AppController {
	
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		$this->Auth->allow(['register', 'logout']);
	}
	
	public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Paginator');
    }

	public function index() {
		$this->set('users', $this->Users->find('all'));
	}

	public function profile() {
		if (!$this->Auth->user()) {
			return $this->redirect(['controller' => 'Users', 'action' => 'login']);
		}

		$user = $this->Users->get($this->Auth->user('id'));
		if ($this->request->is('put')) {
			$usersTable = TableRegistry::get('Users');

			$verify = (new DefaultPasswordHasher)->check($this->request->data['current_password'], $user->password);
			if ($verify) {
				$passwordUpdate = false;

				if (strlen($this->request->data['new_password']) > 0 && $this->request->data['new_password'] === $this->request->data['new_password_confirm']) {
					$this->request->data['password'] = $this->request->data['new_password'];
					$passwordUpdate = true;
				}

				unset($this->request->data['current_password']);
				unset($this->request->data['new_password']);
				unset($this->request->data['new_password_confirm']);

				$usersTable->patchEntity($user, $this->request->data);
				if ($usersTable->save($user)) {
					if ($passwordUpdate) {
						$this->Flash->success('Profile and password updated');
					} else {
						$this->Flash->success('Profile updated');
					}
				}
			} else {
				$this->Flash->error(__('Incorrect current password entered.'));
			}
		}

		$this->set(compact('user'));
	}

	public function register() {
		if ($this->Auth->user()) {
			return $this->redirect(['controller' => 'Users', 'action' => 'profile']);
		}

		$user = $this->Users->newEntity();
		if ($this->request->is('post')) {
			$user = $this->Users->patchEntity($user, $this->request->data);
			if ($this->Users->save($user)) {
				$this->Auth->setUser($user->toArray());
				$this->Flash->success(__('The user has been saved.'));
				return $this->redirect([
							'controller' => 'Users',
							'action' => 'home'
				]);
			}
			$this->Flash->error(__('Unable to add the user.'));
		}
		$this->set('user', $user);
	}

	public function login() {
		if ($this->Auth->user()) {
			return $this->redirect($this->Auth->redirectUrl());
		}

		$user = $this->Users->newEntity();
		if ($this->request->is('post')) {
			$user = $this->Auth->identify();
			if ($user) {
				$this->Auth->setUser($user);
				if ($this->Auth->authenticationProvider()->needsPasswordRehash()) {
					$user = $this->Users->get($this->Auth->user('id'));
					$user->password = $this->request->data('password');
					$this->Users->save($user);
				}
				return $this->redirect($this->Auth->redirectUrl());
			}
			unset($this->request->data['password']);
			$this->Flash->error(__('Invalid username or password, try again'));
		}
		$this->set('user', $user);
	}

	public function logout() {
		return $this->redirect($this->Auth->logout());
	}

	public function dashboard() {
		
	}

	public function billing() {
		$userID = $this->Auth->user('id');
		
		$paymentsTable = TableRegistry::get('Payments');
		$payments = $paymentsTable->find()->where(['Payments.user_id =' => $userID]);
		
		$paginateConfig = [
			'limit' => 10,
			'order' => [
				'Payments.id' => 'desc'
			]
		];
		
		$creditPrice = number_format(Configure::read('WebAudit.CreditPrice'), 2);
		$creditCurrency = Configure::read('WebAudit.CreditCurrency');

		$this->set(compact('userID', 'creditPrice', 'creditCurrency'));
		$this->set('payments', $this->Paginator->paginate($payments, $paginateConfig));
	}

}
