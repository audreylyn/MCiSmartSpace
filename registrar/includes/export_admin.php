<?php
require '../../auth/dbh.inc.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="dept_admins.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, ['AdminID', 'FirstName', 'LastName', 'Department', 'Email']); // Header row

$query = $conn->query("SELECT AdminID, FirstName, LastName, Department, Email FROM dept_admin");
while ($row = $query->fetch_assoc()) {
    fputcsv($output, $row);
}

fclose($output);
exit();
