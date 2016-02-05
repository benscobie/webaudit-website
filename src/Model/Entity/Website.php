<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Website extends Entity {

	// Make all fields mass assignable except for primary key field "id".
	protected $_accessible = [
		'*' => true,
		'id' => false
	];
	
	public function generateVerificationContent() {
		$this->verification_content = sha1(random_bytes(40));
	}
	
	public function getVerificationTXTRecord() {
		return ('webaudit-site-verification=' . $this->verification_content);
	}
	
	public function getVerificationFileUploadFileName() {
		return ("webaudit_" . substr(md5($this->verification_content), 0, 16) . ".html");
	}
	
	public function getFullUrl($trailingSlash = FALSE) {
		$url = $this->protocol . "://" . $this->hostname;
		return $trailingSlash ? $url . "/": $url;
	}
	
	public function getVerificationFileUploadUrl() {
		return ($this->getFullUrl() . "/" . $this->getVerificationFileUploadFileName()	);
	}

}
