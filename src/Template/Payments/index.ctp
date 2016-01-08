<?php $this->assign('title', 'Payments'); ?>
<div class="payments">
    <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" id="PayPalForm" name="PayPalForm"  target="_top">
        <input type="hidden" name="cmd" value="_xclick">   
        <input type="hidden" name="business" value="admin@benscobie.com">
        <input type="hidden" name="amount" value="0.01">
        <input type="hidden" name="item_name" value="Web Audit Scanning Credits">
        <input type="hidden" name="item_number" value="1">
        <input type="hidden" name="currency_code" value="GBP">
        <input type="hidden" name="notify_url" value="http://webaudit.benscobie.com/payments/paypal_ipn">
        <input type="hidden" name="cancel_return" value="http://webaudit.benscobie.com/payments/paypal_cancel">
        <input type="hidden" name="return" value="http://webaudit.benscobie.com/payments/paypal_complete">
        <input type="hidden" name="notify_url" value="http://webaudit.benscobie.com/payments/paypal_complete"> 
        <input type="image" border="0" name="submit" src="http://images.paypal.com/images/x-click-but5.gif" alt="Make payments with PayPal - it's fast, free and secure.">
    </form>
</div>