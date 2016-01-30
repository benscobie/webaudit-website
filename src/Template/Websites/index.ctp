<?php $this->assign('title', 'Websites'); ?>
<div class="websites form">
	<?= $this->Form->create($website, ['id' => 'add-new-website']) ?>
		<div class="form-group">
			<label>Add new website</label>
			<div class="input-group">
				<span class="input-group-btn">
					<select class="btn">
						<option>HTTP</option>
						<option>HTTPS</option>
					</select>
				</span>
				<input type="text" class="form-control">
				<span class="input-group-btn">
					<button class="btn btn-default" type="button">Verify</button>
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
			</tr>
		</thead>
		<tbody>
		<?php
		foreach ($websites as $website) { ?>
			<tr>
				<th scope="row"><?= $website['protocol'] . '://' . $website['url'] ?></th>
				<th scope="row"><?= $website['status'] ?></th>
			</tr>
		<?php
		}
		?>
		</tbody>
	</table>
	<?php } ?>
</div>