<?php
// Include session security helper
require_once 'session_security.php';

// Include simple rate limiter
require_once 'RateLimiter.php';

// Initialize secure session settings
initSecureSession();

// Now start the session
session_start();

// Include database configuration
require_once '../database/config.php';

// Get database connection
$conn = get_db_connection();

// Initialize error message variable
$error_message = "";

// Create simple rate limiter instance (5 attempts per 5 minutes)
$rateLimiter = new RateLimiter(5, 300);

// Get client IP address for rate limiting
$clientIP = $_SERVER['REMOTE_ADDR'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the client is rate limited
    if ($rateLimiter->isRateLimited($clientIP)) {
        $timeRemaining = $rateLimiter->getTimeRemaining($clientIP);
        $minutes = ceil($timeRemaining / 60);
        $error_message = "Too many failed login attempts. Please try again after {$minutes} minute(s).";
    } else {
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        // Basic validation
        if (empty($email) || empty($password)) {
            $error_message = "Email and password are required.";
        } else {
            $loginSuccessful = false;

            // Check registrar
            $stmt = $conn->prepare("SELECT regid, Reg_Password FROM registrar WHERE Reg_Email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                // Direct password comparison for registrar
                if ($password === $row['Reg_Password']) {
                    $_SESSION['user_id'] = $row['regid'];
                    $_SESSION['role'] = 'Registrar';

                    // Regenerate session ID for security
                    regenerateSessionId();

                    // Reset rate limiter on successful login
                    $rateLimiter->reset($clientIP);

                    header("Location: ../registrar/reg_add_admin.php");
                    exit();
                }
            }

            // Check dept_admin
            $stmt = $conn->prepare("SELECT AdminID, FirstName, Password, Department FROM dept_admin WHERE Email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                // Verify the password
                if (password_verify($password, $row['Password'])) {
                    $_SESSION['user_id'] = $row['AdminID'];
                    $_SESSION['role'] = 'Department Admin';
                    $_SESSION['first_name'] = $row['FirstName'];
                    $_SESSION['department'] = $row['Department'];

                    // Regenerate session ID for security
                    regenerateSessionId();

                    // Reset rate limiter on successful login
                    $rateLimiter->reset($clientIP);

                    header("Location: ../department-admin/dept-admin.php");
                    exit();
                }
            }

            // Check teacher
            $stmt = $conn->prepare("SELECT TeacherID, FirstName, Password FROM teacher WHERE Email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                // Verify the password
                if (password_verify($password, $row['Password'])) {
                    $_SESSION['user_id'] = $row['TeacherID'];
                    $_SESSION['role'] = 'Teacher';
                    $_SESSION['first_name'] = $row['FirstName'];

                    // Regenerate session ID for security
                    regenerateSessionId();

                    // Reset rate limiter on successful login
                    $rateLimiter->reset($clientIP);

                    header("Location: ../teacher/tc_browse_room.php");
                    exit();
                }
            }

            // Check student
            $stmt = $conn->prepare("SELECT StudentId, FirstName, Password FROM student WHERE Email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                // Verify the password
                if (password_verify($password, $row['Password'])) {
                    $_SESSION['user_id'] = $row['StudentId'];
                    $_SESSION['role'] = 'Student';
                    $_SESSION['first_name'] = $row['FirstName'];

                    // Regenerate session ID for security
                    regenerateSessionId();

                    // Reset rate limiter on successful login
                    $rateLimiter->reset($clientIP);

                    header("Location: ../student/std_browse_room.php");
                    exit();
                }
            }

            // If we get here, login failed
            // Increment failed login counter
            $attempts = $rateLimiter->increment($clientIP);
            $remainingAttempts = $rateLimiter->getRemainingAttempts($clientIP);

            if ($remainingAttempts > 0) {
                $error_message = "Invalid credentials. You have {$remainingAttempts} login attempts remaining.";
            } else {
                $timeRemaining = $rateLimiter->getTimeRemaining($clientIP);
                $minutes = ceil($timeRemaining / 60);
                $error_message = "Too many failed login attempts. Your account is temporarily locked. Please try again after {$minutes} minute(s).";
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        .error-message {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
            padding: 10px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <?php if (!empty($error_message)): ?>
        <div class="error-message">
            <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php endif; ?>

    <!-- Login form will be included from index.php -->
    <script>
        window.location.href = "../index.php<?php echo !empty($error_message) ? '?error=' . urlencode($error_message) : ''; ?>";
    </script>
</body>

</html>