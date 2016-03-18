<div class="scans">
	<div class="row">
		<div id="scan-test-container" class="col-md-4">
			<div id="scan-test-row-header">
				Tests
			</div>
			<?php
				$testNameLookup = [
					'HEADERS' => 'HTTP Headers',
					'SSL' => 'SSL/TLS'
				];
				
				foreach ($scan['tests'] as $test) {
					$extraClasses = [];
					if ($test['status'] != 2 ) {
						$extraClasses[] = 'disabled ';
					}
					?>
					<div class="scan-test-row <?= implode($extraClasses, " "); ?>" data-test-id="<?= $test['id']; ?>">
						<div class="row">
							<div class="col-xs-8">
								<?= $testNameLookup[$test['name']]; ?>
							</div>
							<div class="col-xs-4">
								<i class="fa fa-circle-o-notch fa-spin fa-pull-right <?= ($test['status'] == 1 ) ? '' : 'hide' ?>"></i>
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