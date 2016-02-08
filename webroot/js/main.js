$(document).ready(function() {
	$('#add-new-website select').change(function() {
		$(this).closest('form').find('input').focus();
	});
	
	$('input[name="creditOptionsRadios"]:radio').change(function() {
		var credit_amount = $(this).val();
		$('#creditPurchasePayPalForm').find('input[name="quantity"]').val(credit_amount);
	});
});