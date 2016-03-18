<div class="scans" data-scan-status="<?= $scan['status']; ?>">
	<div class="row">
		<div id="scan-test-container" class="col-md-4">
			<div id="scan-test-row-header">
				Tests
			</div>
			<?php
				foreach ($scan['tests'] as $test) {
					$extraClasses = [];
					if ($test['status'] != 2 ) {
						$extraClasses[] = 'disabled ';
					}
					?>
					<div class="scan-test-row <?= implode($extraClasses, " "); ?>" data-test-id="<?= $test['id']; ?>" data-test-status=<?= $test['status']; ?>>
						<div class="row">
							<div class="col-xs-8">
								<?= $this->Test->getFriendlyName($test['name']); ?>
							</div>
							<div class="col-xs-4">
								<i class="fa fa-circle-o-notch fa-spin fa-pull-right <?= ($test['status'] == 1 ) ? '' : 'test-in-progress' ?>"></i>
							</div>
						</div>
					</div>
					<?php
				}
			?>
		</div>
		<div class="col-md-8">
		</div>
	</div>

</div>
<script>
	initScanPageUpdater(<?= $scan['id']; ?>);
</script>