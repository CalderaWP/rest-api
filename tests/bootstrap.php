<?php
if( ! function_exists('wp_verify_nonce')) {
	function wp_verify_nonce(){
		return 1;
	}
}

$_ENV[ 'JWT_SECRET' ] = 1234;
