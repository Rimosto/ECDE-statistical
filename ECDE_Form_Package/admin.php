<?php
// admin.php - simple admin summary by Ward and Subcounty
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'ecde_forms';

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($conn->connect_errno) {
    die("DB connection failed: ".$conn->connect_error);
}
$conn->set_charset('utf8mb4');

$ward_q = "SELECT ward, SUM(pp1_boys+pp2_boys) as boys, SUM(pp1_girls+pp2_girls) as girls, SUM(pp1_boys+pp2_boys+pp1_girls+pp2_girls) as total FROM submissions GROUP BY ward ORDER BY total DESC";
$ward_res = $conn->query($ward_q);

$sub_q = "SELECT sub_county, SUM(pp1_boys+pp2_boys) as boys, SUM(pp1_girls+pp2_girls) as girls, SUM(pp1_boys+pp2_boys+pp1_girls+pp2_girls) as total FROM submissions GROUP BY sub_county ORDER BY total DESC";
$sub_res = $conn->query($sub_q);

$all_q = "SELECT id, school_name, ward, sub_county, date_of_entry, pp1_boys, pp1_girls, pp2_boys, pp2_girls FROM submissions ORDER BY created_at DESC LIMIT 200";
$all_res = $conn->query($all_q);
?>
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><title>ECDE Admin</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>body{font-family:Arial;max-width:1100px;margin:20px auto;}table{border-collapse:collapse;width:100%}th,td{border:1px solid #ccc;padding:6px}</style>
</head>
<body>
<h1>ECDE Admin Dashboard</h1>

<h2>Ward Summary</h2>
<canvas id="wardChart" style="max-width:800px;height:300px"></canvas>
<table>
<thead><tr><th>Ward</th><th>Boys</th><th>Girls</th><th>Total</th></tr></thead>
<tbody>
<?php while($r = $ward_res->fetch_assoc()): ?>
<tr><td><?php echo htmlspecialchars($r['ward']); ?></td><td><?php echo $r['boys']; ?></td><td><?php echo $r['girls']; ?></td><td><?php echo $r['total']; ?></td></tr>
<?php endwhile; ?>
</tbody>
</table>

<h2>Subcounty Summary</h2>
<canvas id="subChart" style="max-width:800px;height:300px"></canvas>
<table>
<thead><tr><th>Sub County</th><th>Boys</th><th>Girls</th><th>Total</th></tr></thead>
<tbody>
<?php while($r2 = $sub_res->fetch_assoc()): ?>
<tr><td><?php echo htmlspecialchars($r2['sub_county']); ?></td><td><?php echo $r2['boys']; ?></td><td><?php echo $r2['girls']; ?></td><td><?php echo $r2['total']; ?></td></tr>
<?php endwhile; ?>
</tbody>
</table>

<h2>Recent Submissions</h2>
<table>
<thead><tr><th>ID</th><th>School</th><th>Ward</th><th>Sub County</th><th>Date</th><th>PP1 Boys</th><th>PP1 Girls</th><th>PP2 Boys</th><th>PP2 Girls</th></tr></thead>
<tbody>
<?php while($a = $all_res->fetch_assoc()): ?>
<tr>
<td><?php echo $a['id']; ?></td>
<td><?php echo htmlspecialchars($a['school_name']); ?></td>
<td><?php echo htmlspecialchars($a['ward']); ?></td>
<td><?php echo htmlspecialchars($a['sub_county']); ?></td>
<td><?php echo $a['date_of_entry']; ?></td>
<td><?php echo $a['pp1_boys']; ?></td>
<td><?php echo $a['pp1_girls']; ?></td>
<td><?php echo $a['pp2_boys']; ?></td>
<td><?php echo $a['pp2_girls']; ?></td>
</tr>
<?php endwhile; ?>
</tbody>
</table>

<script>
(function(){
  const wardLabels = [], wardTotals = [];
  const rows = document.querySelectorAll('table tbody')[0].querySelectorAll('tr');
  rows.forEach(r=>{ const cols = r.querySelectorAll('td'); wardLabels.push(cols[0].innerText); wardTotals.push(Number(cols[3].innerText)); });
  const ctx = document.getElementById('wardChart').getContext('2d');
  new Chart(ctx, { type: 'bar', data: { labels: wardLabels, datasets: [{ label: 'Total Learners', data: wardTotals }] } });
})();

(function(){
  const subLabels = [], subTotals = [];
  const rows = document.querySelectorAll('table tbody')[1].querySelectorAll('tr');
  rows.forEach(r=>{ const cols = r.querySelectorAll('td'); subLabels.push(cols[0].innerText); subTotals.push(Number(cols[3].innerText)); });
  const ctx = document.getElementById('subChart').getContext('2d');
  new Chart(ctx, { type: 'bar', data: { labels: subLabels, datasets: [{ label: 'Total Learners', data: subTotals }] } });
})();
</script>

</body>
</html>
