<?php
// Include session security helper
require_once __DIR__ . '/session_security.php';

// Initialize secure session settings if session hasn't started yet
if (session_status() == PHP_SESSION_NONE) {
    initSecureSession();
    session_start();
}

/**
 * Check if user has access to the requested page
 * 
 * @param array $allowedRoles Array of roles allowed to access the page
 * @param int $timeout Session timeout in seconds (default: 30 minutes)
 * @return void
 */
function checkAccess($allowedRoles, $timeout = 1800)
{
    // Check if session exists
    if (!isset($_SESSION['role'])) {
        header("Location: ../index.php");
        exit();
    }

    // Check for session timeout
    if (!checkSessionTimeout($timeout)) {
        // Session timed out, redirect to login page
        header("Location: ../index.php?error=timeout");
        exit();
    }

    // Validate session security
    if (!validateSession()) {
        // Session validation failed, potential session hijacking attempt
        // Clear session and redirect to login page
        secureLogout();
        header("Location: ../index.php?error=security");
        exit();
    }

    // Check if user has permission to access the page
    if (!in_array($_SESSION['role'], $allowedRoles)) {
        echo "You don't have permission to access this page.";
        exit();
    }
}
