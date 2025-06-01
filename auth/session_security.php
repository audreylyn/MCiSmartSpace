<?php

/**
 * Session Security Helper
 * 
 * Contains functions to enhance PHP session security
 */

/**
 * Initialize secure session settings
 * Call this before session_start()
 */
function initSecureSession()
{
    // Set secure cookie parameters
    session_set_cookie_params([
        'lifetime' => 3600, // 1 hour lifetime
        'path' => '/',
        'secure' => true,    // Only transmit cookie over HTTPS
        'httponly' => true,  // Prevent JavaScript access to the cookie
        'samesite' => 'Lax' // Prevent CSRF attacks
    ]);
}

/**
 * Regenerate session ID securely
 * Call this after successful authentication
 */
function regenerateSessionId()
{
    // Regenerate session ID, deleting old session file
    session_regenerate_id(true);

    // Set last activity time for session timeout
    $_SESSION['last_activity'] = time();

    // Set additional session security attributes
    $_SESSION['created'] = time();
    $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];

    // Optional: Store IP for additional verification
    $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
}

/**
 * Check if session has timed out
 * @param int $timeout Timeout period in seconds (default: 30 minutes)
 * @return bool True if session is valid, false if timed out
 */
function checkSessionTimeout($timeout = 1800)
{
    // Check if session has activity timestamp
    if (isset($_SESSION['last_activity'])) {
        // Check if session has expired
        if (time() - $_SESSION['last_activity'] > $timeout) {
            // Session has expired, destroy it
            session_unset();
            session_destroy();
            return false;
        }

        // Update last activity time
        $_SESSION['last_activity'] = time();
    }

    return true;
}

/**
 * Validate session integrity
 * Helps prevent session hijacking
 * @return bool True if session is valid
 */
function validateSession()
{
    // Check if basic session data is set
    if (!isset($_SESSION['created']) || !isset($_SESSION['user_agent'])) {
        return false;
    }

    // Validate browser user agent hasn't changed
    if ($_SESSION['user_agent'] != $_SERVER['HTTP_USER_AGENT']) {
        return false;
    }

    // Optional: Validate IP address (commented out because can cause problems with dynamic IPs)
    // if ($_SESSION['ip_address'] != $_SERVER['REMOTE_ADDR']) {
    //     return false;
    // }

    // Expire session after 12 hours regardless of activity
    if (time() - $_SESSION['created'] > 43200) {
        return false;
    }

    return true;
}

/**
 * Secure logout function
 * Properly destroys the session
 */
function secureLogout()
{
    // Clear all session variables
    $_SESSION = [];

    // Delete the session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    // Destroy the session
    session_destroy();
}
