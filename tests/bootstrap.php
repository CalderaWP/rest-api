<?php
//When testing the CSFR protection, session must be started
//BTW This is a bad smell.
if (PHP_SESSION_NONE === session_status()) {
	session_start();
}

