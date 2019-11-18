<?php
	require_once "stripe-php-master/init.php";
	require_once "products.php";

	$stripeDetails = array(
		"secretKey" => "sk_test_5nknVZuNYvIQFD2B1neo7d7h00ukG9BsiN",
		"publishableKey" => "pk_test_0JpCUYDFRozrRt4iXNCJuJkd0091xRixmq"
	);

	\Stripe\Stripe::setApiKey($stripeDetails['secretKey']);
?>
