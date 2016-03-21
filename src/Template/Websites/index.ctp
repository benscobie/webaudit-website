<?php 
use \App\Model\Entity\Scan;
$this->assign('title', 'Websites'); ?>
<div class="websites form">
	<?= $this->Form->create($website, ['id' => 'add-new-website']) ?>
		<div class="form-group">
			<label>Add new website</label>
			<div class="input-group">
				<span class="input-group-btn">
					<?php
					$options = ['http' => 'HTTP', 'https' => 'HTTPS'];
					echo $this->Form->select('protocol', $options, ['class' => 'btn']);
					?>
				</span>
				<?= $this->Form->text('hostname', ['class' => 'form-control']); ?>
				<span class="input-group-btn">
					<?= $this->Form->button('Add & Verify', ['type' => 'submit', 'class' => 'btn btn-default']); ?>
				</span>
			</div>
		</div>
	<?= $this->Form->end() ?>
	<?php
	if (!empty($websites)) {
	?>
	<table class="table">
		<thead>
			<tr>
				<th><?= $this->Paginator->sort('hostname', 'Website URL') ?></th>
				<th><?= $this->Paginator->sort('verified', 'Status') ?></th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach ($websites as $website) { ?>
			<tr>
				<th scope="row"><?= $website->getFullUrl(); ?></th>
				<th scope="row"><?= (!$website['verified']) ? "Unverified" : "Verified"  ?></th>
				<th scope="row"><?php
				$scan = Scan::getActiveScanForWebsite($website->id);
				
				if (!$website['verified']) {
					echo $this->Html->link('Verify', ['controller' => 'Websites', 'action' => 'verify', $website->id]);
				} elseif (empty($scan)) {
					echo $this->Html->link('Start Scan', ['controller' => 'Websites', 'action' => 'scan', $website->id]);
				} else {
					echo $this->Html->link('View Scan', ['controller' => 'Scans', 'action' => 'view', $scan->id]);
				}
				?></th>
			</tr>
		<?php
		}
		?>
		</tbody>
	</table>
	<?php
	if ($this->Paginator->hasPage(2)) {
	?>
		<nav>
			<ul class="pagination">
			<?php
			echo $this->Paginator->prev('<span aria-hidden="true">&laquo;</span>', array('escape'=>false,'tag' => 'li'), null, array('escape'=>false, 'tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
			echo $this->Paginator->numbers(['first' => 1]);
			echo $this->Paginator->next('<span aria-hidden="true">&raquo;</span>', array('escape'=>false, 'tag' => 'li','currentClass' => 'disabled'), null, array('escape'=>false,'tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
			?>
			</ul>
		</nav>
	<?php }
	} ?>
</div>