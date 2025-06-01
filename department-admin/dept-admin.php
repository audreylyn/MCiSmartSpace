<?php
require '../auth/middleware.php';
checkAccess(['Department Admin']);

// Initialize session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Set current page for navigation highlighting
$current_page = 'dashboard';

require_once '../database/config.php';
$conn = get_db_connection();

// Get room statuses
require_once 'includes/dashboard.php';

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.9.95/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../public/css/admin_styles/main.css">
    <link rel="stylesheet" href="../public/css/admin_styles/main_2.css">
    <link rel="stylesheet" href="../public/css/admin_styles/style-all.css">

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary-color: #1e5631;
            /* Dark forest green */
            --secondary-color: #d4af37;
            /* Timeless gold */
            --accent-color: #0f2d1a;
            /* Darker green */
            --success-color: #2e7d32;
            /* Forest green */
            --danger-color: #c62828;
            /* Deep red */
            --warning-color: #f9a825;
            /* Gold-yellow */
            --info-color: #0277bd;
            /* Deep blue */
            --text-color: #333;
            --text-muted: #6c757d;
            --bg-color: #f8f9fa;
            --card-bg: #ffffff;
            --border-radius: 12px;
            --box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            --transition: all 0.3s ease;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
        }

        .dashboard-container {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 20px;
            padding: 20px;
        }

        .stat-card {
            grid-column: span 3;
            background-color: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 24px;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            border-left: 4px solid var(--primary-color);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .chart-card {
            grid-column: span 6;
            background-color: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 20px;
            transition: var(--transition);
        }

        .chart-card:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .chart-card-full {
            grid-column: span 12;
        }

        .issues-card {
            grid-column: span 12;
        }

        .stat-value {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--primary-color);
        }

        .stat-label {
            font-size: 1rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding-bottom: 15px;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .card-title .icon {
            margin-right: 8px;
            color: var(--primary-color);
        }

        .card-content {
            position: relative;
        }

        .issue-item {
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 12px;
            background-color: rgba(0, 0, 0, 0.02);
            transition: var(--transition);
        }

        .issue-item:hover {
            background-color: rgba(0, 0, 0, 0.04);
        }

        .issue-item:last-child {
            margin-bottom: 0;
        }

        .issue-title {
            font-weight: 600;
            margin-bottom: 6px;
            font-size: 1.05rem;
        }

        .issue-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .badge {
            display: inline-block;
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-pending {
            background-color: var(--warning-color);
            color: #000;
        }

        .badge-in-progress {
            background-color: var(--info-color);
            color: #fff;
        }

        .badge-resolved {
            background-color: var(--success-color);
            color: #fff;
        }

        .badge-rejected {
            background-color: var(--danger-color);
            color: #fff;
        }

        .action-link {
            display: inline-block;
            padding: 8px 16px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
            text-align: center;
            margin-top: 16px;
        }

        .action-link:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .stat-icon {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 2.5rem;
            color: var(--secondary-color);
        }

        /* Responsive adjustments */
        @media (max-width: 1200px) {
            .stat-card {
                grid-column: span 6;
            }

            .chart-card {
                grid-column: span 12;
            }
        }

        @media (max-width: 768px) {
            .dashboard-container {
                grid-template-columns: repeat(6, 1fr);
                gap: 15px;
                padding: 15px;
            }

            .stat-card {
                grid-column: span 3;
            }

            .chart-card,
            .issues-card {
                grid-column: span 6;
            }
        }

        @media (max-width: 576px) {
            .stat-card {
                grid-column: span 6;
            }
        }

        .quick-links {
            grid-column: span 12;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .quick-link-card {
            background-color: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 20px;
            display: flex;
            flex-direction: column;
            transition: var(--transition);
            height: 100%;
        }

        .quick-link-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .quick-link-header {
            margin-bottom: 16px;
        }

        .quick-link-title {
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 4px;
        }

        .quick-link-subtitle {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .quick-link-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 16px;
            opacity: 0.8;
        }

        .quick-link-footer {
            margin-top: auto;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .quick-link-btn {
            flex: 1;
            padding: 8px 12px;
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
            border-radius: 6px;
            text-align: center;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .quick-link-btn:hover {
            background-color: var(--primary-color);
            color: white;
        }

        /* Main section adjustments */
        .section.main-section {
            padding: 0;
            margin: 0;
            max-width: 100%;
        }

        /* Style updates to match site theme */
        .stat-card .stat-icon {
            color: var(--primary-color);
        }

        .stat-value {
            color: var(--primary-color);
        }

        .chart-header h3 {
            color: var(--primary-color);
        }

        .status-badge.pending {
            background-color: var(--warning-color);
        }

        .status-badge.in-progress {
            background-color: var(--info-color);
        }

        .status-badge.resolved {
            background-color: var(--success-color);
        }

        .status-badge.rejected {
            background-color: var(--danger-color);
        }

        .issues-header h3 {
            color: var(--primary-color);
        }
    </style>
</head>

<body>
    <div id="app">
        <nav id="navbar-main" class="navbar is-fixed-top">
            <div class="navbar-brand">
                <a class="navbar-item mobile-aside-button">
                    <span class="icon"><i class="mdi mdi-forwardburger mdi-24px"></i></span>
                </a>
                <div class="navbar-item">
                    <section class="is-title-bar">
                        <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
                            <ul>
                                <li>Department Admin</li>
                                <li>Dashboard</li>
                            </ul>
                        </div>
                    </section>
                </div>
            </div>
            <div class="navbar-brand is-right">
                <a class="navbar-item --jb-navbar-menu-toggle" data-target="navbar-menu">
                    <span class="icon"><i class="mdi mdi-dots-vertical mdi-24px"></i></span>
                </a>
            </div>
            <div class="navbar-menu" id="navbar-menu">
                <div class="navbar-end">
                    <div class="navbar-item dropdown has-divider">
                        <a class="navbar-link">
                            <span>Hello, <?php echo $_SESSION['first_name']; ?></span>
                            <span class="icon">
                                <i class="mdi mdi-chevron-down"></i>
                            </span>
                        </a>
                        <div class="navbar-dropdown">
                            <a class="navbar-item" href="../auth/logout.php">
                                <span class="icon"><i class="mdi mdi-logout"></i></span>
                                <span>Log Out</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <aside class="aside is-placed-left is-expanded">
            <div class="aside-tools">
                <div class="logo">
                    <a href="#"><img class="meyclogo" src="../public/assets/logo.webp" alt="logo"></a>
                    <p>MCiSmartSpace</p>
                </div>
            </div>
            <div class="menu is-menu-main">
                <ul class="menu-list">
                    <li class="active">
                        <a href="#">
                            <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="24" height="24" stroke-width="2">
                                    <path d="M5 4h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1"></path>
                                    <path d="M5 16h4a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-2a1 1 0 0 1 1 -1"></path>
                                    <path d="M15 12h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1"></path>
                                    <path d="M15 4h4a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-2a1 1 0 0 1 1 -1"></path>
                                </svg></span>
                            <span>Dashboard</span>
                        </a>
                    </li>
                </ul>
                <ul class="menu-list">
                    <li>
                        <a href="dept_room_approval.php">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-building2">
                                    <path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"></path>
                                    <path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"></path>
                                    <path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"></path>
                                    <path d="M10 6h4"></path>
                                    <path d="M10 10h4"></path>
                                    <path d="M10 14h4"></path>
                                    <path d="M10 18h4"></path>
                                </svg>
                            </span>
                            <span>Room Approval</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown" onclick="toggleIcon(this)">
                            <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="24" height="24" stroke-width="2">
                                    <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                                </svg></span>
                            <span class="#">Manage Accounts</span>
                            <span class="icon toggle-icon"><i class="mdi mdi-plus"></i></span>
                        </a>
                        <ul>
                            <li>
                                <a href="dept_add_teacher.php">
                                    <span>Add Teacher</span>
                                </a>
                            </li>
                            <li>
                                <a href="dept_add_student.php">
                                    <span>Add Student</span>
                                </a>
                            </li>
                            <li>
                                <a href="dept_edit_teachers.php">
                                    <span>Edit Teachers</span>
                                </a>
                            </li>
                            <li>
                                <a href="dept_edit_students.php">
                                    <span>Edit Students</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="dept_equipment_report.php">
                            <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="24" height="24" stroke-width="2">
                                    <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 0 0-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 0 0-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 0 0-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 0 0-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 0 0 1.066-2.573c-.94-1.543.826-3.31 2.37-2.37c.996.608 2.296.07 2.572-1.065z"></path>
                                    <path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"></path>
                                </svg></span>
                            <span>Equipment Report</span>
                        </a>
                    </li>
                    <li>
                        <a href="qr_generator.php">
                            <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-qr-code">
                                    <rect width="5" height="5" x="3" y="3" rx="1"></rect>
                                    <rect width="5" height="5" x="16" y="3" rx="1"></rect>
                                    <rect width="5" height="5" x="3" y="16" rx="1"></rect>
                                    <path d="M21 16h-3a2 2 0 0 0-2 2v3"></path>
                                    <path d="M21 21v.01"></path>
                                    <path d="M12 7v3a2 2 0 0 1-2 2H7"></path>
                                    <path d="M3 12h.01"></path>
                                    <path d="M12 3h.01"></path>
                                    <path d="M12 16v.01"></path>
                                    <path d="M16 12h1"></path>
                                    <path d="M21 12v.01"></path>
                                    <path d="M12 21v-1"></path>
                                </svg></span>
                            <span>QR Generator</span>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>

        <section class="section main-section">
            <div class="dashboard-container">

                <!-- Statistics Cards -->
                <div class="stat-card">
                    <i class="mdi mdi-account-tie stat-icon"></i>
                    <div class="stat-value"><?php echo $teacher_count; ?></div>
                    <div class="stat-label">Teachers</div>
                </div>

                <div class="stat-card">
                    <i class="mdi mdi-account-group stat-icon"></i>
                    <div class="stat-value"><?php echo $student_count; ?></div>
                    <div class="stat-label">Students</div>
                </div>

                <div class="stat-card">
                    <i class="mdi mdi-clock-alert stat-icon"></i>
                    <div class="stat-value"><?php echo $pending_requests; ?></div>
                    <div class="stat-label">Pending Requests</div>
                </div>

                <div class="stat-card">
                    <i class="mdi mdi-alert-circle stat-icon"></i>
                    <div class="stat-value"><?php echo $unresolved_issues; ?></div>
                    <div class="stat-label">Unresolved Issues</div>
                </div>

                <!-- First Row Charts -->
                <div class="chart-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <span class="icon"><i class="mdi mdi-chart-pie"></i></span>
                            Room Request Status
                        </h3>
                    </div>
                    <div class="card-content">
                        <canvas id="roomStatusChart" height="220"></canvas>
                    </div>
                </div>

                <!-- Second Row Charts -->
                <div class="chart-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <span class="icon"><i class="mdi mdi-chart-bar"></i></span>
                            Equipment Issues by Status
                        </h3>
                    </div>
                    <div class="card-content">
                        <canvas id="issuesStatusChart" height="220"></canvas>
                    </div>
                </div>

                <!-- Recent Issues Section -->
                <div class="chart-card issues-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <span class="icon"><i class="mdi mdi-clipboard-alert"></i></span>
                            Recent Equipment Issues
                        </h3>
                    </div>
                    <div class="card-content">
                        <?php if (count($recent_issues) > 0): ?>
                            <?php foreach ($recent_issues as $issue): ?>
                                <div class="issue-item">
                                    <div class="issue-title"><?php echo htmlspecialchars($issue['equipment_name']); ?> - <?php echo htmlspecialchars($issue['issue_type']); ?></div>
                                    <div class="issue-meta">
                                        <span>Reported: <?php echo date('M j, Y g:i A', strtotime($issue['reported_at'])); ?></span>
                                        <span class="badge badge-<?php echo strtolower($issue['status']); ?>"><?php echo $issue['status']; ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <a href="dept_equipment_report.php" class="action-link">View All Issues</a>
                        <?php else: ?>
                            <p class="text-center py-4">No recent equipment issues reported.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script type="text/javascript" src="../public/js/admin_scripts/main.min.js"></script>
    <script>
        // Toggle dropdown menu
        function toggleIcon(el) {
            el.classList.toggle("active");
            var icon = el.querySelector(".toggle-icon i");
            if (icon.classList.contains("mdi-plus")) {
                icon.classList.remove("mdi-plus");
                icon.classList.add("mdi-minus");
            } else {
                icon.classList.remove("mdi-minus");
                icon.classList.add("mdi-plus");
            }
            var submenu = el.nextElementSibling;
            if (submenu) {
                if (submenu.style.display === "block") {
                    submenu.style.display = "none";
                } else {
                    submenu.style.display = "block";
                }
            }
        }

        // Initialize charts once the DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Room Status Chart - Updated colors to match site theme
            const roomStatusData = {
                pending: <?php echo isset($room_stats['pending']) ? $room_stats['pending'] : 0; ?>,
                approved: <?php echo isset($room_stats['approved']) ? $room_stats['approved'] : 0; ?>,
                rejected: <?php echo isset($room_stats['rejected']) ? $room_stats['rejected'] : 0; ?>
            };

            const roomStatusChart = new Chart(
                document.getElementById('roomStatusChart'), {
                    type: 'pie',
                    data: {
                        labels: ['Pending', 'Approved', 'Rejected'],
                        datasets: [{
                            data: [roomStatusData.pending, roomStatusData.approved, roomStatusData.rejected],
                            backgroundColor: ['#d4af37', '#1e5631', '#c62828'], // Gold, Dark Green, Deep Red
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.raw || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = Math.round((value / total) * 100);
                                        return `${label}: ${value} (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                }
            );

            // Equipment Issues Chart - Updated colors to match site theme
            const issueStatusData = {
                pending: <?php echo isset($issue_stats['pending']) ? $issue_stats['pending'] : 0; ?>,
                in_progress: <?php echo isset($issue_stats['in_progress']) ? $issue_stats['in_progress'] : 0; ?>,
                resolved: <?php echo isset($issue_stats['resolved']) ? $issue_stats['resolved'] : 0; ?>,
                rejected: <?php echo isset($issue_stats['rejected']) ? $issue_stats['rejected'] : 0; ?>
            };

            const issuesStatusChart = new Chart(
                document.getElementById('issuesStatusChart'), {
                    type: 'pie',
                    data: {
                        labels: ['Pending', 'In Progress', 'Resolved', 'Rejected'],
                        datasets: [{
                            data: [
                                issueStatusData.pending,
                                issueStatusData.in_progress,
                                issueStatusData.resolved,
                                issueStatusData.rejected
                            ],
                            backgroundColor: [
                                '#d4af37', // Gold for pending
                                '#3e7650', // Medium green for in progress
                                '#1e5631', // Dark green for resolved
                                '#c62828' // Deep red for rejected
                            ],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.raw || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = Math.round((value / total) * 100);
                                        return `${label}: ${value} (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                }
            );
        });
    </script>
</body>

</html>