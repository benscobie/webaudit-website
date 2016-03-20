<div class="scans form">
<?php
if (!empty($scans)) {
?>
<table class="table">
	<thead>
		<tr>
			<th>Website URL</th>
			<th class="hidden-xs hidden-sm"><?= $this->Paginator->sort('created_date', 'Requested Date') ?></th>
			<th class="hidden-xs hidden-sm"><?= $this->Paginator->sort('started_date', 'Started Date') ?></th>
			<th class="hidden-xs"><?= $this->Paginator->sort('finished_date', 'Finished Date') ?></th>
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
			<th scope="row" class="hidden-xs hidden-sm"><?= $scan->created_date;  ?></th>
			<th scope="row" class="hidden-xs hidden-sm"><?= $scan->started_date;  ?></th>
			<th scope="row" class="hidden-xs"><?= $scan->finished_date;  ?></th>
			<th scope="row"><?= $scan->getStatusMessage();  ?></th>
			<th scope="row"><?= $this->Html->link('View Report', ['controller' => 'Scans', 'action' => 'view', $scan->id]); ?></th>
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
<?php
}
} ?>
</div>