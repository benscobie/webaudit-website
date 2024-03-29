<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\I18n\Time;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	
	public $renderLayoutTitle = true;

	/**
	 * Initialization hook method.
	 *
	 * Use this method to add common initialization code like loading components.
	 *
	 * e.g. `$this->loadComponent('Security');`
	 *
	 * @return void
	 */
	public function initialize() {
		parent::initialize();

		$this->loadComponent('RequestHandler');
		$this->loadComponent('Flash');
		$this->loadComponent('Csrf');
		$this->loadComponent('Security');
		$this->loadComponent('Auth', [
			'loginRedirect' => [
				'controller' => 'Websites',
				'action' => 'index'
			],
			'logoutRedirect' => [
				'controller' => 'Pages',
				'action' => 'display',
				'home'
			],
			'authError' => 'Access denied',
			'authenticate' => [
				'Form' => [
					'userModel' => 'Users',
					'fields' => [
						'username' => 'email'
					]
				]
			],
		]);
	}

	/**
	 * Before render callback.
	 *
	 * @param \Cake\Event\Event $event The beforeRender event.
	 * @return void
	 */
	public function beforeRender(Event $event) {
		if (!array_key_exists('_serialize', $this->viewVars) &&
				in_array($this->response->type(), ['application/json', 'application/xml'])) {
			$this->set('_serialize', true);
		}
		
		Time::setToStringFormat('dd/MM/yy, HH:MM');
		Time::setJsonEncodeFormat('dd/MM/yy, HH:MM');

		$this->set('renderLayoutTitle', $this->renderLayoutTitle);
		$this->set('userLoggedIn', $this->Auth->user());
	}

	public function beforeFilter(Event $event) {
		$this->Auth->allow(['index', 'view', 'display']);
	}

}
