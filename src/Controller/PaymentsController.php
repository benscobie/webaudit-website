<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use wadeshuler\paypalipn\IpnListener;

class PaymentsController extends AppController {

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		$this->Auth->allow('paypalIpn');
	}

	public function index() {
		$this->set('payments', $this->Payments->find('all'));
	}
    
    public function paypalIpn() {
        $this->autoRender = false;
        // https://developer.paypal.com/developer/ipnSimulator/
		
		$listener = new IpnListener();
		
		$listener->use_sandbox = true;
		$listener->use_curl = true;
		$listener->follow_location = false;
		$listener->timeout = 30;
		$listener->verify_ssl = true;

		if ($verified = $listener->processIpn())
		{
			// Valid IPN
			/*
				1. Check that $_POST['payment_status'] is "Completed"
				2. Check that $_POST['txn_id'] has not been previously processed
				3. Check that $_POST['receiver_email'] is your Primary PayPal email
				4. Check that $_POST['payment_amount'] and $_POST['payment_currency'] are correct
			*/
            
            $this->request->data['payment_status'];
            $this->request->data['txn_id'];
            $this->request->data['payment_amount'];
			
			$transactionData = $listener->getPostData();
			file_put_contents('ipn_success.log', print_r($transactionData, true) . PHP_EOL, LOCK_EX | FILE_APPEND);
		} else {
			$errors = $listener->getErrors();
			file_put_contents('ipn_errors.log', print_r($errors, true) . PHP_EOL, LOCK_EX | FILE_APPEND);
		}
    }
    
    public function paymentCancel() {
        
    }
    
    public function paymentComplete() {
        
    }

}
