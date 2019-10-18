<?php
/*
*
* Adds a shortcode to grab data for Enterprise Data Warehouse
*
*/
function loadEDWData() {
	ob_start();
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL,"https://ws.admin.washington.edu/decisionsupport/v1/dataavailability");
	curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_SSLVERSION, 4);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec ($curl);
	echo($result);
	curl_close($curl);
	return ob_get_clean();
}
add_shortcode('edwload', 'loadEDWData');