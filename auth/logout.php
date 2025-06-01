<?php
// Include session security helper
require_once 'session_security.php';

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Use secure logout function
secureLogout();

// Redirect to login page
header("Location: ../index.php");
exit();
