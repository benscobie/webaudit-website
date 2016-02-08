<?php $this->assign('title', 'Verify Website'); ?>
<div class="websites form">
	<p>In order to use the WebAudit scanning service you must verify that you
	own the site/domain. This can be done by uploading a file
	to the website's directory.
	</p>
	
	<h3>File upload</h3>
	<p>Follow the steps below to upload a file to your website to prove that you own the domain.</p>
	<ol>
		<li><strong>Download</strong> this HTML verification file</li>
		<li><strong>Upload</strong> the file to <?= $website->getFullUrl(TRUE); ?></li>
		<li><strong>Confirm</strong> successful upload by visiting <?= $this->Html->link($website->getVerificationFileUploadUrl()); ?> in your browser</li>
		<li><strong>Click</strong> Verify below</li>
	</ol>
	<p>
		To stay verified, do not remove the HTML file after validation.
	</p>
	<?= $this->Html->link('Verify', [ 'controller' => 'Websites', 'action' => 'verify', $website->id, 'verify'], ['class' => 'btn btn-success'])  ?>
	<?= $this->Html->link('Cancel', [ 'controller' => 'Websites', 'action' => 'index'], ['class' => 'btn btn-default'])  ?>
</div>