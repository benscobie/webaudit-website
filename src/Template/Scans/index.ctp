<div class="scans form">
<?php
if (!empty($scans)) {
?>
<table class="table">
	<thead>
		<tr>
			<th>Website URL</th>
			<th>Requested Date</th>
			<th>Started Date</th>
			<th>Finished Date</th>
			<th>Scan Status</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	foreach ($scans as $scan) {
		?>
		<tr>
			<th scope="row"><?= $scan->website->getFullUrl(); ?></th>
			<th scope="row"><?= $scan->created_date;  ?></th>
			<th scope="row"><?= $scan->started_date;  ?></th>
			<th scope="row"><?= $scan->finished_date;  ?></th>
			<th scope="row"><?= $scan->getStatusMessage();  ?></th>
			<th scope="row"><?= $this->Html->link('View Report', ['controller' => 'Scans', 'action' => 'view', $scan->id]); ?></th>
		</tr>
	<?php
	}
	?>
	</tbody>
</table>

<nav>
	<ul class="pagination">
	<?php
	echo $this->Paginator->prev('<span aria-hidden="true">&laquo;</span>', array('escape'=>false,'tag' => 'li'), null, array('escape'=>false, 'tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
	echo $this->Paginator->numbers(['first' => 1]);
	echo $this->Paginator->next('<span aria-hidden="true">&raquo;</span>', array('escape'=>false, 'tag' => 'li','currentClass' => 'disabled'), null, array('escape'=>false,'tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
	?>
	</ul>
</nav>
<?php } ?>
</div>