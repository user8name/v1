<?php

// Global user functions
// Page Loading event
function Page_Loading() {

	//echo "Page Loading";
	require_once($_SERVER['DOCUMENT_ROOT'].'/wp-config.php');
	if(!is_user_logged_in() || !current_user_can('level_10')){
		echo 'Please log in.';
		die();
	}
}

// Page Rendering event
function Page_Rendering() {

	//echo "Page Rendering";
}

// Page Unloaded event
function Page_Unloaded() {

	//echo "Page Unloaded";
}
?>
