<?php
use \App\Model\Entity\Scan;

$this->assign('title', 'Scan report');
?>
<div class="page-header">
	<h1><?= $this->fetch('title'); ?> <?php
	if ($scan['status'] == Scan::STATUS_QUEUED) { ?>
		<small class="scan-status">Position in queue: <span><?= $queuePosition; ?></span></small>
		<?php
	} elseif ($scan['status'] == Scan::STATUS_IN_PROGRESS){ ?>
		<small class="scan-status">Scan in progress</small>
		<?php
	} elseif ($scan['status'] == Scan::STATUS_COMPLETED){ ?>
		<small class="scan-status">Finished on <?= $scan['finished_date']; ?></small>
		<?php
	}
	?>
	</h1>
	
</div>
<div class="scans" data-scan-status="<?= $scan['status']; ?>">
	<div class="row">
		<div id="scan-test-container" class="col-md-4">
			<div id="scan-test-row-header">
				Checks performed
			</div>
			<?php
			if (!empty($scan['tests'])) {
				foreach ($scan['tests'] as $testRan) {
					?>
					<div class="scan-test-row <?= (isset($test) && $test['id'] == $testRan['id']) ? 'active' : ''; ?> <?= $testRan['status'] != 2 ? 'disabled' : ''; ?>" data-test-id="<?= $testRan['id']; ?>" data-test-status=<?= $testRan['status']; ?>>
						<div class="row">
							<div class="col-xs-8">
								<?= $testRan['friendly_name']; ?>
							</div>
							<div class="col-xs-4">
								<i class="fa fa-circle-o-notch fa-spin fa-pull-right test-progress-indicator <?= $testRan['status'] == 1 ? '' : 'hide' ?>"></i>
							</div>
						</div>
					</div>
					<?php
				}
			} else {
				?>
				<div class="scan-test-row-example">
					<div class="row">
						<div class="col-xs-12">
							Checks will appear in this list
						</div>
					</div>
				</div>
				<?php
			}
			?>
		</div>
		<div id="scan-test-result-container" class="col-md-8" data-test-id="<?= isset($test) ? $test['id'] : ""; ?>">
			<?php
			if (isset($test)) {
				echo $this->render('/Tests/' . strtolower($test['name']), false);
			}
			?>
		</div>
	</div>
</div>
<div id="help-modal" class="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="exampleModalLabel">Help</h4>
			</div>
			<div class="modal-body">
			</div>
		</div>
	</div>
</div>
<script id="scan-test-row-template" type="text/x-handlebars-template">
<div class="scan-test-row {{row_classes}}" data-test-id="{{test_id}}" data-test-status="{{test_status}}" style="display: none;">
	<div class="row">
		<div class="col-xs-8">
			{{test_friendly_name}}
		</div>
		<div class="col-xs-4">
			<i class="fa fa-circle-o-notch fa-spin fa-pull-right test-progress-indicator {{progress_classes}}"></i>
		</div>
	</div>
</div>
</script>
<script>
var initialTimouet = 500;
if ( <?= $scan['status']; ?> === <?= Scan::STATUS_QUEUED; ?>) {
	initialTimouet = 2000;
}

var $testResultContainer = $('#scan-test-result-container');
var $helpModal = $('#help-modal');
var $modalBody = $helpModal.find('.modal-body');

bindScanTestRows();
bindTestResultPage($testResultContainer);
setTimeout(function () {
	initScanPageUpdater(<?= $scan['id']; ?>);
}, initialTimouet);

function initScanPageUpdater(scanID) {
	var source = $("#scan-test-row-template").html();
	var template = Handlebars.compile(source);

	if (parseInt($('.scans').data('scan-status')) !== 2) {
		updateScanProgress(scanID, template);
	}
}

function bindScanTestRows() {
	$(document).off('click', '.scan-test-row').on('click', '.scan-test-row',function(e) {
		if (!$(this).hasClass('disabled')) {
			var testID = parseInt($(this).data('test-id'));
			var that = $(this);
			getTestResult(testID, function() {
				$('.scan-test-row').removeClass('active');
				that.addClass('active');
			});
		}
	});
}

function bindTestResultPage($content) {
	$content.find('.scan-help-link').click(function() {
		var test = $(this).data('test');
		var scrollto = $(this).data('scrollto');
		loadHelpPage(test, scrollto);
		return false;
	});
}

$helpModal.on('hide.bs.modal', function (e) {
	// Fix for not scrolling after every other help page request
	$modalBody.scrollTop(0);
});

$helpModal.on('show.bs.modal', function (e) {
	resizeModal();
});

function loadHelpPage(test, scrollto) {
	$.get('/help/tests/' + test)
	.done(function(data) {
		$modalBody.html(data);
		$helpModal.modal('show');
		var helpLink = $modalBody.find('[data-scrollto=' + scrollto + ']');
		if (helpLink.length !== 0) {
			var padding = $modalBody.offset().top - $('body').offset().top + 10;
			$modalBody.scrollTop(helpLink.offset().top - padding);
		}
	})
	.fail(function() {

	});
}

$(window).resize(resizeModal);
function resizeModal() {
	var height = $(window).height() - 155;
	$modalBody.css({"height":height,"overflow-y":"auto"});
}

var ajaxCount = 0;
function getTestResult(testID, callback) {
	var currentTestIdShown = parseInt($testResultContainer.data('test-id'));
	if (currentTestIdShown !== testID) {
		var seqNumber = ++ajaxCount;
		$.get('/tests/view/' + testID)
		.done(function(data) {
			if (seqNumber === ajaxCount) {
				$testResultContainer.data('test-id', testID);
				$testResultContainer.html(data);
				bindTestResultPage($testResultContainer);
				callback();
			}
		})
		.fail(function() {

		});
	}
}

var exampleTestRemoved = <?= !empty($scan['tests']) ? 'true' : 'false' ?>;
function updateScanProgress(scanID, template) {
	$.getJSON('/scans/getprogress/' + scanID)
	.done(function(data) {
		var oldStatus = parseInt($('.scans').data('scan-status'));
		var newStatus = data.scan.status;
		$('.scans').data('scan-status', newStatus);
		
		if (newStatus === <?= Scan::STATUS_QUEUED; ?>) {
			var newPositionInQueue = data.scan.position_in_queue;
			if (oldStatus === <?= Scan::STATUS_QUEUED; ?>) {
				var oldQueuePosition = parseInt($('.scan-status span').text());
				if (oldQueuePosition !== newPositionInQueue) {
					$('.scan-status span').fadeOut(function() {
						$(this).html(newPositionInQueue).fadeIn();
					});
				}
			} else {
				$('.scan-status').fadeOut(function() {
					$(this).html('Position in queue: <span>' + newPositionInQueue + '</span>').fadeIn();
				});
			}
		}
		
		if (oldStatus != <?= Scan::STATUS_IN_PROGRESS; ?> && newStatus == <?= Scan::STATUS_IN_PROGRESS; ?>) {
			$('.scan-status').fadeOut(function() {
				$(this).text('Scan in progress').fadeIn();
			});
		}
		
		if (oldStatus != <?= Scan::STATUS_COMPLETED; ?> && newStatus == <?= Scan::STATUS_COMPLETED; ?>) {
			$('.scan-status').fadeOut(function() {
				$(this).html('Finished on ' + data.scan.finished_date).fadeIn();
			});
		}
	
		if (!exampleTestRemoved && data.scan.tests.length > 0) {
			$('.scan-test-row-example').remove();
		}
		
		var loadFirstTestPage = false;
		$.each(data.scan.tests, function(key, test) {
			var testID = test.id;
			var testRow = $('.scan-test-row[data-test-id=' + testID + ']');

			if (!testRow.length) {
				var context = {
					test_id: test.id,
					test_status: test.status,
					test_friendly_name: test.friendly_name
				};

				if (test.status !== 1) {
					context.progress_classes = "hide";
				}
				
				if (test.status !== 2) {
					context.row_classes = "disabled"
				}

				var newTestRowHtml = template(context);
				$(newTestRowHtml).appendTo('#scan-test-container').fadeIn('slow');
				
				if (test.status === 2 && $('.scan-test-row active').length === 0) {
					loadFirstTestPage = true;
				}
			} else {
				var status = test.status;
				if (status !== 2) {
					testRow.addClass('disabled');
				} else {
					testRow.removeClass('disabled');
				}
				
				if (status === 1) {
					testRow.find('.test-progress-indicator').removeClass('hide');
				} else {
					testRow.find('.test-progress-indicator').addClass('hide');
				}
				
				if (test.status === 2 && $('.scan-test-row active').length === 0) {
					$('.scan-test-row').first().click();
				}
			}
		});
		
		if (loadFirstTestPage) {
			$('.scan-test-row').first().click();
		}
		
		bindScanTestRows();

		if (newStatus !== 2) {
			var timeout = 500;
			if ( newStatus === <?= Scan::STATUS_QUEUED; ?>) {
				timeout = 2000;
			}
			
			setTimeout(function () {
				updateScanProgress(scanID, template);
			}, timeout);
		}
	})
	.fail(function() {
		setTimeout(function () {
			updateScanProgress(scanID, template);
		}, 500);
	})
	.always(function() {

	}, 'json');
}
</script>