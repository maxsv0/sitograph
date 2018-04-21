<?php

function msv_error_handler() {
	$error = error_get_last();

	if ($error['type'] === E_ERROR) {
		$message = $error["message"] . "<br>" . $error["file"]. ":".$error["line"];
		msv_error($message);
	}
}
