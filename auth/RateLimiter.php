<?php

/**
 * Rate Limiter for Login Attempts
 * This class provides rate limiting functionality for login attempts
 * using PHP sessions as the storage backend.
 */
class RateLimiter
{
    /**
     * @var int Maximum number of attempts allowed within the time window
     */
    private $maxAttempts;

    /**
     * @var int Time window in seconds
     */
    private $timeWindow;

    /**
     * @var string Session key prefix
     */
    private $keyPrefix = 'ratelimit:login:';

    /**
     * Constructor
     * 
     * @param int $maxAttempts Maximum number of attempts allowed
     * @param int $timeWindow Time window in seconds
     */
    public function __construct($maxAttempts = 5, $timeWindow = 300)
    {
        $this->maxAttempts = $maxAttempts;
        $this->timeWindow = $timeWindow;

        // Ensure session is started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Initialize rate limit storage in session if not exists
        //store attempt counts and expiration times
        if (!isset($_SESSION['rate_limits'])) {
            $_SESSION['rate_limits'] = [];
        }
    }

    /**
     * Increment the number of attempts for a given identifier
     * 
     * @param string $identifier Unique identifier (e.g., IP address or username)
     * @return int Current number of attempts
     */
    public function increment($identifier)
    {
        $key = $this->keyPrefix . $identifier;

        // Clean up expired entries
        $this->cleanup();

        // If this is a new attempt, create the entry
        if (!isset($_SESSION['rate_limits'][$key])) {
            $_SESSION['rate_limits'][$key] = [
                'attempts' => 0,
                'expires_at' => time() + $this->timeWindow
            ];
        }

        // Increment the counter
        $_SESSION['rate_limits'][$key]['attempts']++;

        return $_SESSION['rate_limits'][$key]['attempts'];
    }

    /**
     * Check if the identifier is rate limited
     * 
     * @param string $identifier Unique identifier (e.g., IP address or username)
     * @return bool True if rate limited, false otherwise
     */
    public function isRateLimited($identifier)
    {
        $key = $this->keyPrefix . $identifier;

        // Clean up expired entries
        $this->cleanup();

        // If no entry or expired, not rate limited
        if (!isset($_SESSION['rate_limits'][$key])) {
            return false;
        }

        return $_SESSION['rate_limits'][$key]['attempts'] >= $this->maxAttempts;
    }

    /**
     * Get remaining attempts for the identifier
     * 
     * @param string $identifier Unique identifier (e.g., IP address or username)
     * @return int Number of attempts remaining
     */
    public function getRemainingAttempts($identifier)
    {
        $key = $this->keyPrefix . $identifier;

        // Clean up expired entries
        $this->cleanup();

        if (!isset($_SESSION['rate_limits'][$key])) {
            return $this->maxAttempts;
        }

        return max(0, $this->maxAttempts - $_SESSION['rate_limits'][$key]['attempts']);
    }

    /**
     * Get time remaining in seconds before the rate limit resets
     * 
     * @param string $identifier Unique identifier (e.g., IP address or username)
     * @return int Time in seconds until reset, or 0 if not limited
     */
    public function getTimeRemaining($identifier)
    {
        $key = $this->keyPrefix . $identifier;

        // Clean up expired entries
        $this->cleanup();

        if (!isset($_SESSION['rate_limits'][$key])) {
            return 0;
        }

        return max(0, $_SESSION['rate_limits'][$key]['expires_at'] - time());
    }

    /**
     * Reset the rate limit for an identifier
     * 
     * @param string $identifier Unique identifier (e.g., IP address or username)
     */
    public function reset($identifier)
    {
        $key = $this->keyPrefix . $identifier;

        if (isset($_SESSION['rate_limits'][$key])) {
            unset($_SESSION['rate_limits'][$key]);
        }
    }

    /**
     * Clean up expired rate limit entries
     */
    private function cleanup()
    {
        $now = time();

        foreach ($_SESSION['rate_limits'] as $key => $data) {
            if ($data['expires_at'] < $now) {
                unset($_SESSION['rate_limits'][$key]);
            }
        }
    }
}
