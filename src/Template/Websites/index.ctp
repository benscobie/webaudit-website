<?php $this->assign('title', 'Websites'); ?>
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
				<th>Website URL</th>
				<th>Status</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach ($websites as $website) { ?>
			<tr>
				<th scope="row"><?= $website['protocol'] . '://' . $website['hostname'] ?></th>
				<th scope="row"><?= (!$website['verified']) ? "Unverified" : "Verified"  ?></th>
				<th scope="row"><?php
				if (!$website['verified']) {
					echo $this->Html->link('Verify', ['controller' => 'Websites', 'action' => 'verify', $website->id]);
				} elseif (!$website->scanInProgress()) {
					echo $this->Html->link('Start Scan', ['controller' => 'Websites', 'action' => 'scan', $website->id]);
				} else {
					echo $this->Html->link('View Scan', ['controller' => 'Websites', 'action' => 'scan', $website->id]);
				}
				?></th>
			</tr>
		<?php
		}
		?>
		</tbody>
	</table>
	<?php } ?>
</div>