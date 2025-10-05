<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// process.php - receives ECDE form submission and saves to MySQL.
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = 'Pc8tcg#1';
$DB_NAME = 'ecde_forms';

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($conn->connect_errno) {
    die("DB connection failed: " . $conn->connect_error);
}
$conn->set_charset('utf8mb4');

function handle_upload($field_name) {
    if (!isset($_FILES[$field_name]) || $_FILES[$field_name]['error'] !== UPLOAD_ERR_OK) return null;
    $uploads_dir = __DIR__ . '/uploads';
    if (!is_dir($uploads_dir)) mkdir($uploads_dir, 0775, true);
    $tmp = $_FILES[$field_name]['tmp_name'];
    $name = basename($_FILES[$field_name]['name']);
    $ext = pathinfo($name, PATHINFO_EXTENSION);
    $safe = uniqid($field_name . '_') . '.' . preg_replace('/[^a-zA-Z0-9]/', '', $ext);
    $destination = $uploads_dir . '/' . $safe;
    if (move_uploaded_file($tmp, $destination)) return 'uploads/' . $safe;
    return null;
}

// Collect form data
$school_name = $_POST['school_name'] ?? '';
$ward = $_POST['ward'] ?? '';
$sub_county = $_POST['sub_county'] ?? '';
$sponsor_name = $_POST['sponsor_name'] ?? '';
$registration_no = $_POST['registration_no'] ?? '';
$fee_per_term = ($_POST['fee_per_term'] ?? '') !== '' ? floatval($_POST['fee_per_term']) : null;
$email = $_POST['email'] ?? '';
$tel_no = $_POST['tel_no'] ?? '';
$date_of_entry = !empty($_POST['date_of_entry']) ? $_POST['date_of_entry'] : null;

$pp1_boys = intval($_POST['pp1_boys'] ?? 0);
$pp1_girls = intval($_POST['pp1_girls'] ?? 0);
$pp1_streams = intval($_POST['pp1_streams'] ?? 0);
$pp2_boys = intval($_POST['pp2_boys'] ?? 0);
$pp2_girls = intval($_POST['pp2_girls'] ?? 0);
$pp2_streams = intval($_POST['pp2_streams'] ?? 0);
$total_boys = $pp1_boys + $pp2_boys;
$total_girls = $pp1_girls + $pp2_girls;
$total_learners = $total_boys + $total_girls;

$below_4 = intval($_POST['below_4'] ?? 0);
$age_4_5 = intval($_POST['age_4_5'] ?? 0);
$age_5_6 = intval($_POST['age_5_6'] ?? 0);
$above_7 = intval($_POST['above_7'] ?? 0);

$feeding_funding_source = $_POST['feeding_funding_source'] ?? '';
$feeding_sponsor = $_POST['feeding_sponsor'] ?? '';
$feeding_type = $_POST['feeding_type'] ?? '';

$class_perm = intval($_POST['class_perm'] ?? 0);
$class_semi = intval($_POST['class_semi'] ?? 0);
$class_total = intval($_POST['class_total'] ?? 0);
$toilet_perm = intval($_POST['toilet_perm'] ?? 0);
$toilet_semi = intval($_POST['toilet_semi'] ?? 0);
$toilet_total = intval($_POST['toilet_total'] ?? 0);
$kitchen_perm = intval($_POST['kitchen_perm'] ?? 0);
$kitchen_semi = intval($_POST['kitchen_semi'] ?? 0);
$kitchen_total = intval($_POST['kitchen_total'] ?? 0);
$admin_perm = intval($_POST['admin_perm'] ?? 0);
$admin_semi = intval($_POST['admin_semi'] ?? 0);
$admin_total = intval($_POST['admin_total'] ?? 0);

$swing_count = intval($_POST['swing_count'] ?? 0);
$seesaw_count = intval($_POST['seesaw_count'] ?? 0);
$slide_count = intval($_POST['slide_count'] ?? 0);
$merrygo_count = intval($_POST['merrygo_count'] ?? 0);
$other_equipment = $_POST['other_equipment'] ?? '';

$general_remarks = $_POST['general_remarks'] ?? '';
$headteacher_name = $_POST['headteacher_name'] ?? '';
$signature_file = handle_upload('signature_file');
$school_stamp_file = handle_upload('school_stamp_file');

$conn->begin_transaction();

try {
    // Correct: 46 columns → 46 placeholders → 46 params
    $stmt = $conn->prepare("INSERT INTO submissions (
        school_name, ward, sub_county, sponsor_name, registration_no, fee_per_term, email, tel_no, date_of_entry,
        pp1_boys, pp1_girls, pp1_streams, pp2_boys, pp2_girls, pp2_streams, total_boys, total_girls, total_learners,
        below_4, age_4_5, age_5_6, above_7,
        feeding_funding_source, feeding_sponsor, feeding_type,
        class_perm, class_semi, class_total, toilet_perm, toilet_semi, toilet_total,
        kitchen_perm, kitchen_semi, kitchen_total, admin_perm, admin_semi, admin_total,
        swing_count, seesaw_count, slide_count, merrygo_count, other_equipment,
        general_remarks, headteacher_name, signature_file, school_stamp_file
    ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

$stmt->bind_param(
    "sssssdsssiiiiiiiiiiiiisssiiiiiiiiiiiiiiiisssss",
    $school_name, $ward, $sub_county, $sponsor_name, $registration_no, $fee_per_term, $email, $tel_no, $date_of_entry,
    $pp1_boys, $pp1_girls, $pp1_streams, $pp2_boys, $pp2_girls, $pp2_streams, $total_boys, $total_girls, $total_learners,
    $below_4, $age_4_5, $age_5_6, $above_7,
    $feeding_funding_source, $feeding_sponsor, $feeding_type,
    $class_perm, $class_semi, $class_total, $toilet_perm, $toilet_semi, $toilet_total,
    $kitchen_perm, $kitchen_semi, $kitchen_total, $admin_perm, $admin_semi, $admin_total,
    $swing_count, $seesaw_count, $slide_count, $merrygo_count,
    $other_equipment, $general_remarks, $headteacher_name, $signature_file, $school_stamp_file
);

    if (!$stmt->execute()) throw new Exception("Insert submission failed: " . $stmt->error);
    $submission_id = $stmt->insert_id;
    $stmt->close();

    // Teachers table
    if (!empty($_POST['teacher_name'])) {
        $tnames = $_POST['teacher_name'];
        $ttscs = $_POST['teacher_tsc'] ?? [];
        $tgenders = $_POST['teacher_gender'] ?? [];
        $tdegrees = $_POST['teacher_degree'] ?? [];
        $tdiplomas = $_POST['teacher_diploma'] ?? [];
        $tcerts = $_POST['teacher_certificate'] ?? [];
        $tremarks = $_POST['teacher_remarks'] ?? [];
        $tsnos = $_POST['teacher_sno'] ?? [];

        $stmt_t = $conn->prepare("INSERT INTO teachers (submission_id, s_no, teacher_name, tsc_no, gender, degree, diploma, certificate, remarks) VALUES (?,?,?,?,?,?,?,?,?)");
        for ($i = 0; $i < count($tnames); $i++) {
            $sno = intval($tsnos[$i] ?? ($i + 1));
            $name = $tnames[$i] ?? '';
            $tsc = $ttscs[$i] ?? '';
            $gender = $tgenders[$i] ?? '';
            $degree = isset($tdegrees[$i]) ? 1 : 0;
            $diploma = isset($tdiplomas[$i]) ? 1 : 0;
            $cert = isset($tcerts[$i]) ? 1 : 0;
            $remark = $tremarks[$i] ?? '';
            $stmt_t->bind_param("iisssiiis", $submission_id, $sno, $name, $tsc, $gender, $degree, $diploma, $cert, $remark);
            if (!$stmt_t->execute()) throw new Exception("Insert teacher failed: " . $stmt_t->error);
        }
        $stmt_t->close();
    }

    // Non-teaching staff
    if (!empty($_POST['non_name'])) {
        $n_names = $_POST['non_name'];
        $n_duties = $_POST['non_duties'] ?? [];
        $n_snos = $_POST['non_sno'] ?? [];
        $stmt_n = $conn->prepare("INSERT INTO non_teaching_staff (submission_id, s_no, name, duties) VALUES (?,?,?,?)");
        for ($i = 0; $i < count($n_names); $i++) {
            $sno = intval($n_snos[$i] ?? ($i + 1));
            $name = $n_names[$i] ?? '';
            $duties = $n_duties[$i] ?? '';
            $stmt_n->bind_param("iiss", $submission_id, $sno, $name, $duties);
            if (!$stmt_n->execute()) throw new Exception("Insert non-staff failed: " . $stmt_n->error);
        }
        $stmt_n->close();
    }

    // SNE learners
    if (!empty($_POST['sne_class'])) {
        $sne_classes = $_POST['sne_class'];
        $sne_genders = $_POST['sne_gender'] ?? [];
        $sne_visual = $_POST['sne_visual'] ?? [];
        $sne_hearing = $_POST['sne_hearing'] ?? [];
        $sne_physical = $_POST['sne_physical'] ?? [];
        $sne_mental = $_POST['sne_mental'] ?? [];
        $sne_others = $_POST['sne_others'] ?? [];
        $stmt_s = $conn->prepare("INSERT INTO sne_learners (submission_id, class_name, gender, visual_impairment, hearing_impairment, physical_handicap, mental_handicap, others) VALUES (?,?,?,?,?,?,?,?)");
        for ($i = 0; $i < count($sne_classes); $i++) {
            $cls = $sne_classes[$i] ?? '';
            $gender = $sne_genders[$i] ?? '';
            $visual = intval($sne_visual[$i] ?? 0);
            $hearing = intval($sne_hearing[$i] ?? 0);
            $physical = intval($sne_physical[$i] ?? 0);
            $mental = intval($sne_mental[$i] ?? 0);
            $others = intval($sne_others[$i] ?? 0);
            $stmt_s->bind_param("issiiiii", $submission_id, $cls, $gender, $visual, $hearing, $physical, $mental, $others);
            if (!$stmt_s->execute()) throw new Exception("Insert SNE failed: " . $stmt_s->error);
        }
        $stmt_s->close();
    }

$conn->commit();

// Redirect to dashboard after success
header("Location: dashboard.php?success=1&id=" . $submission_id);
exit();

} catch (Exception $e) {
    $conn->rollback();
    echo "Error saving form: " . $e->getMessage();
}

$conn->close();
?>

