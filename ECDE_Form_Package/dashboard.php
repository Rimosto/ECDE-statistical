<?php
// Connect to database
$conn = new mysqli("localhost", "root", "Pc8tcg#1", "ecde_forms");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all records
$result = $conn->query("SELECT * FROM submissions ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ECDE Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>ECDE Form Submissions Dashboard</h2>
        <a href="export_excel.php" class="btn btn-success">Export All to Excel</a>
    </div>

    <div class="table-responsive" style="max-height: 85vh; overflow-y: auto;">
        <table class="table table-bordered table-striped table-hover table-sm">
            <thead class="table-dark sticky-top">
                <tr>
                    <th>ID</th>
                    <th>School Name</th>
                    <th>Ward</th>
                    <th>Sub County</th>
                    <th>Sponsor Name</th>
                    <th>Registration No</th>
                    <th>Fee per Term</th>
                    <th>Email</th>
                    <th>Tel No</th>
                    <th>Date of Entry</th>
                    <th>PP1 Boys</th>
                    <th>PP1 Girls</th>
                    <th>PP1 Streams</th>
                    <th>PP2 Boys</th>
                    <th>PP2 Girls</th>
                    <th>PP2 Streams</th>
                    <th>Total Boys</th>
                    <th>Total Girls</th>
                    <th>Total Learners</th>
                    <th>Below 4</th>
                    <th>Age 4–5</th>
                    <th>Age 5–6</th>
                    <th>Above 7</th>
                    <th>Feeding Funding Source</th>
                    <th>Feeding Sponsor</th>
                    <th>Feeding Type</th>
                    <th>Class Perm</th>
                    <th>Class Semi</th>
                    <th>Class Total</th>
                    <th>Toilet Perm</th>
                    <th>Toilet Semi</th>
                    <th>Toilet Total</th>
                    <th>Kitchen Perm</th>
                    <th>Kitchen Semi</th>
                    <th>Kitchen Total</th>
                    <th>Admin Perm</th>
                    <th>Admin Semi</th>
                    <th>Admin Total</th>
                    <th>Swing Count</th>
                    <th>Seesaw Count</th>
                    <th>Slide Count</th>
                    <th>Merry-Go Count</th>
                    <th>Other Equipment</th>
                    <th>General Remarks</th>
                    <th>Headteacher Name</th>
                    <th>Signature File</th>
                    <th>School Stamp File</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <?php foreach ($row as $value): ?>
                                <td><?= htmlspecialchars($value ?? '') ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="47" class="text-center text-muted">No records found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
<?php
$conn->close();
?>

