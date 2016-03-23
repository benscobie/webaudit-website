<?php $this->assign('title', 'Verify Website'); ?>
<div class="websites form">
	<p>In order to use the WebAudit scanning service you must verify that you
	own the site/domain. This can be done by uploading a file
	to the website's directory.
	</p>
	
	<h3>File upload</h3>
	<p>Follow the steps below to upload a file to your website to prove that you own the domain.</p>
	<ol>
		<li><strong>Download</strong> <?= $this->Html->link('this HTML verification file', [ 'controller' => 'Websites', 'action' => 'verify', $website->id, 'download']); ?></li>
		<li><strong>Upload</strong> the file to <?= $website->getFullUrl(TRUE); ?></li>
		<li><strong>Confirm</strong> successful upload by visiting <?= $this->Html->link($website->getVerificationFileUploadUrl()); ?> in your browser</li>
		<li><strong>Click</strong> Verify below</li>
	</ol>
	<p>
		Do not remove the HTML file after initial verification as verification will be performed before every scan starts.
	</p>
	<?= $this->Html->link('Verify', [ 'controller' => 'Websites', 'action' => 'verify', $website->id, 'verify'], ['class' => 'btn btn-success'])  ?>
	<?= $this->Html->link('Cancel', [ 'controller' => 'Websites', 'action' => 'index'], ['class' => 'btn btn-default'])  ?>
</div>