<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=ECDE_Submissions.xls");

$conn = new mysqli("localhost", "root", "Pc8tcg#1", "ecde_forms");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM submissions ORDER BY id DESC");

echo "<table border='1'>";
echo "<tr>";
$fields = $result->fetch_fields();
foreach ($fields as $field) {
    echo "<th>{$field->name}</th>";
}
echo "</tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    foreach ($row as $value) {
        echo "<td>" . htmlspecialchars($value ?? '') . "</td>";
    }
    echo "</tr>";
}
echo "</table>";

$conn->close();
?>

