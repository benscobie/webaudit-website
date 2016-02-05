<?php $this->assign('title', 'Verify Website'); ?>
<div class="websites form">
	<p>In order to use the WebAudit scanning service you must verify that you
	own the site or domain. There are currently two ways of proving ownership,
	one way is by creating a DNS TXT record. The other way is by uploading a file
	to the websites root directory.
	</p>
	
	<h3>DNS TXT record</h3>
	<p>Follow the steps below to create a DNS record to prove that you own the domain.</p>
	<p>
		<strong>1. Add the TXT record below to your domains DNS configuration.</strong>
		<div class="form-group">
			<?= $this->Form->input('txt_record', ['label' => 'TXT Record', 'class' => 'form-control', 'value' => $website->getVerificationTXTRecord()] ) ?>
		</div>
		<strong>2. Click Verify below</strong>
	</p>
	<p>
		To stay verified, do not remove the DNS record after validation.
	</p>
	
	<h3>File upload</h3>
	<p>Following the steps below to create a DNS record to prove that you own the domain.</p>
	<ol>
		<li><strong>Download</strong> this HTML verification file</li>
		<li><strong>Upload</strong> the file to <?= $website->getFullUrl(TRUE); ?></li>
		<li><strong>Confirm</strong> successful upload by visiting <?= $this->Html->link($website->getVerificationFileUploadUrl()); ?> in your browser</li>
		<li><strong>Click</strong> Verify below</li>
	</ol>
	<p>
		To stay verified, do not remove the HTML file after validation.
	</p>
</div>