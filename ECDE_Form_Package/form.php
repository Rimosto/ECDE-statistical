<?php
// index.php - ECDE form front-end (same as provided earlier)
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<title> Naivasha Sub-County ECDE Monthly Statistical Data Capture Form</title>
<style>body { font-family: Arial, sans-serif; max-width:1100px; margin:20px auto; background:#ccc; } h2 { background:#ddd; padding:10px; } .grid { display:grid; grid-template-columns: 1fr 1fr; gap:10px; } label { display:block; margin-bottom:4px; font-weight:600; } input[type="text"], input[type="number"], input[type="email"], textarea, select, input[type="date"] { width:100%; padding:6px; box-sizing:border-box; margin-bottom:10px; } table { width:100%; border-collapse:collapse; margin-bottom:10px; } table th, table td { border:1px solid #ccc; padding:6px; text-align:left; } .btn { padding:6px 12px; cursor:pointer; } .btn-add { margin-bottom:10px; } .section { border:1px solid #ddd; padding:10px; margin-bottom:14px; }</style>
</head>
<body>
<h1>  Naivasha Sub-County ECDE Monthly Statistical Data Capture Form</h1>
<form id="ecdeForm" action="process.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm();">
  <div class="section">
    <h2>Section 1: School Information</h2>
    <div class="grid">
      <div>
        <label>Name of Pre School</label><input type="text" name="school_name" id="school_name" required>
        <label>Ward</label><input type="text" name="ward" id="ward" required>
        <label>Sub County</label><input type="text" name="sub_county" id="sub_county" required>
        <label>Sponsor Name</label><input type="text" name="sponsor_name" id="sponsor_name">
        <label>Registration No.</label><input type="text" name="registration_no" id="registration_no">
      </div>
      <div>
        <label>Fee per Term (KES)</label><input type="number" step="0.01" name="fee_per_term" id="fee_per_term">
        <label>Email Address</label><input type="email" name="email" id="email">
        <label>Tel No.</label><input type="text" name="tel_no" id="tel_no">
        <label>Date of Entry</label><input type="date" name="date_of_entry" id="date_of_entry" required>
      </div>
    </div>
  </div>
  <div class="section">
    <h2>Section 2: Enrollment & Staffing (PP1 / PP2)</h2>
    <table>
      <thead><tr><th>Class</th><th>Boys</th><th>Girls</th><th>Streams</th></tr></thead>
      <tbody>
        <tr>
          <td>PP1</td>
          <td><input type="number" min="0" name="pp1_boys" id="pp1_boys" value="0"></td>
          <td><input type="number" min="0" name="pp1_girls" id="pp1_girls" value="0"></td>
          <td><input type="number" min="0" name="pp1_streams" id="pp1_streams" value="0"></td>
        </tr>
        <tr>
          <td>PP2</td>
          <td><input type="number" min="0" name="pp2_boys" id="pp2_boys" value="0"></td>
          <td><input type="number" min="0" name="pp2_girls" id="pp2_girls" value="0"></td>
          <td><input type="number" min="0" name="pp2_streams" id="pp2_streams" value="0"></td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="section">
    <h2>Section 3: Enrollment Details by Age</h2>
    <div class="grid">
      <div>
        <label>Below 4 Years</label><input type="number" min="0" name="below_4" id="below_4" value="0">
        <label>4 - 5 Years</label><input type="number" min="0" name="age_4_5" id="age_4_5" value="0">
      </div>
      <div>
        <label>5 - 6 Years</label><input type="number" min="0" name="age_5_6" id="age_5_6" value="0">
        <label>Above 7 Years</label><input type="number" min="0" name="above_7" id="above_7" value="0">
      </div>
    </div>
  </div>
  <div class="section">
    <h2>Section 4: Details of SNE Learners</h2>
    <button type="button" class="btn btn-add" onclick="addSneRow()">+ Add SNE entry</button>
    <table id="sne_table"><thead><tr><th>Class</th><th>Gender</th><th>Visual Impairment</th><th>Hearing Impairment</th><th>Physical Handicap</th><th>Mental Handicap</th><th>Others</th><th>Action</th></tr></thead><tbody></tbody></table>
  </div>
  <div class="section">
    <h2>Section 5: Staffing Details (Teachers)</h2>
    <button type="button" class="btn btn-add" onclick="addTeacherRow()">+ Add Teacher</button>
    <table id="teacher_table"><thead><tr><th>S/No</th><th>Teacher's Name</th><th>TSC No.</th><th>Gender</th><th>Degree</th><th>Diploma</th><th>Certificate</th><th>Remarks</th><th>Action</th></tr></thead><tbody></tbody></table>
  </div>
  <div class="section">
    <h2>Section 6: Non-Teaching Staff</h2>
    <button type="button" class="btn btn-add" onclick="addNonStaffRow()">+ Add Non-Teaching Staff</button>
    <table id="nonstaff_table"><thead><tr><th>S/No</th><th>Name</th><th>Duties</th><th>Action</th></tr></thead><tbody></tbody></table>
  </div>
  <div class="section">
    <h2>Section 7: Feeding Programme</h2>
    <div class="grid">
      <div>
        <label>Source of Funding</label><input type="text" name="feeding_funding_source" id="feeding_funding_source">
        <label>Name of Sponsor</label><input type="text" name="feeding_sponsor" id="feeding_sponsor">
      </div>
      <div>
        <label>Type of Food</label><input type="text" name="feeding_type" id="feeding_type">
      </div>
    </div>
  </div>
  <div class="section">
    <h2>Section 8: ECDE Buildings / Facilities</h2>
    <table><thead><tr><th>Facility</th><th>Permanent</th><th>Semi-Permanent</th><th>Total</th></tr></thead><tbody>
        <tr><td>Classrooms</td><td><input type="number" min="0" name="class_perm" value="0"></td><td><input type="number" min="0" name="class_semi" value="0"></td><td><input type="number" min="0" name="class_total" value="0"></td></tr>
        <tr><td>Toilets</td><td><input type="number" min="0" name="toilet_perm" value="0"></td><td><input type="number" min="0" name="toilet_semi" value="0"></td><td><input type="number" min="0" name="toilet_total" value="0"></td></tr>
        <tr><td>Kitchen</td><td><input type="number" min="0" name="kitchen_perm" value="0"></td><td><input type="number" min="0" name="kitchen_semi" value="0"></td><td><input type="number" min="0" name="kitchen_total" value="0"></td></tr>
        <tr><td>Admin Block/Office</td><td><input type="number" min="0" name="admin_perm" value="0"></td><td><input type="number" min="0" name="admin_semi" value="0"></td><td><input type="number" min="0" name="admin_total" value="0"></td></tr>
      </tbody></table>
  </div>
  <div class="section">
    <h2>Section 9: Fixed Play Equipment</h2>
    <div class="grid">
      <div><label>Swing</label><input type="number" min="0" name="swing_count" value="0"></div>
      <div><label>Sea-saw</label><input type="number" min="0" name="seesaw_count" value="0"></div>
      <div><label>Slide</label><input type="number" min="0" name="slide_count" value="0"></div>
      <div><label>Merry Go-Round</label><input type="number" min="0" name="merrygo_count" value="0"></div>
      <div style="grid-column:1 / -1;"><label>Other Equipment (describe)</label><input type="text" name="other_equipment"></div>
    </div>
  </div>
  <div class="section">
    <h2>Section 10: General Remarks</h2>
    <textarea name="general_remarks" rows="4"></textarea>
  </div>
  <div class="section">
    <h2>Section 11: Certification</h2>
    <div class="grid">
      <div>
        <label>Name of Headteacher</label><input type="text" name="headteacher_name" required>
        <label>Tel No</label><input type="text" name="headteacher_tel">
      </div>
      <div>
        <label>Signature (image file)</label><input type="file" name="signature_file" accept="image/*">
        <label>School Stamp (image)</label><input type="file" name="school_stamp_file" accept="image/*">
      </div>
    </div>
  </div>
  <div style="text-align:center;"><button type="submit" class="btn">Submit Form</button></div>
</form>
<script>
let teacherCount=0, sneCount=0, nonStaffCount=0;
function addTeacherRow(data={}) {
  teacherCount++;
  const tbody = document.querySelector('#teacher_table tbody');
  const tr = document.createElement('tr');
  tr.innerHTML = `
    <td><input type="number" name="teacher_sno[]" value="${teacherCount}" style="width:60px;"></td>
    <td><input type="text" name="teacher_name[]" value="${data.name||''}"></td>
    <td><input type="text" name="teacher_tsc[]" value="${data.tsc||''}"></td>
    <td><select name="teacher_gender[]"><option value="">--</option><option value="Male">Male</option><option value="Female">Female</option></select></td>
    <td><input type="checkbox" name="teacher_degree[]" value="1"></td>
    <td><input type="checkbox" name="teacher_diploma[]" value="1"></td>
    <td><input type="checkbox" name="teacher_certificate[]" value="1"></td>
    <td><input type="text" name="teacher_remarks[]"></td>
    <td><button type="button" onclick="this.closest('tr').remove()">Remove</button></td>
  `;
  tbody.appendChild(tr);
}
function addSneRow(data={}) {
  sneCount++;
  const tbody = document.querySelector('#sne_table tbody');
  const tr = document.createElement('tr');
  tr.innerHTML = `
    <td><input type="text" name="sne_class[]" value="${data.class||''}"></td>
    <td><select name="sne_gender[]"><option value="">--</option><option>Male</option><option>Female</option></select></td>
    <td><input type="number" name="sne_visual[]" value="${data.visual||0}" min="0"></td>
    <td><input type="number" name="sne_hearing[]" value="${data.hearing||0}" min="0"></td>
    <td><input type="number" name="sne_physical[]" value="${data.physical||0}" min="0"></td>
    <td><input type="number" name="sne_mental[]" value="${data.mental||0}" min="0"></td>
    <td><input type="number" name="sne_others[]" value="${data.others||0}" min="0"></td>
    <td><button type="button" onclick="this.closest('tr').remove()">Remove</button></td>
  `;
  tbody.appendChild(tr);
}
function addNonStaffRow(data={}) {
  nonStaffCount++;
  const tbody = document.querySelector('#nonstaff_table tbody');
  const tr = document.createElement('tr');
  tr.innerHTML = `
    <td><input type="number" name="non_sno[]" value="${nonStaffCount}" style="width:60px;"></td>
    <td><input type="text" name="non_name[]" value="${data.name||''}"></td>
    <td><input type="text" name="non_duties[]" value="${data.duties||''}"></td>
    <td><button type="button" onclick="this.closest('tr').remove()">Remove</button></td>
  `;
  tbody.appendChild(tr);
}
addTeacherRow(); addNonStaffRow();
function validateForm(){
  const school = document.getElementById('school_name').value.trim();
  const ward = document.getElementById('ward').value.trim();
  const subcounty = document.getElementById('sub_county').value.trim();
  const date = document.getElementById('date_of_entry').value;
  if(!school || !ward || !subcounty || !date){
    alert('Please fill required school info fields and date.');
    return false;
  }
  const nums = ['pp1_boys','pp1_girls','pp2_boys','pp2_girls'];
  for(let id of nums){
    const v = document.getElementById(id).value;
    if (v === '' || isNaN(v) || Number(v) < 0) {
      alert('Please ensure enrollment numbers are numeric and non-negative.');
      return false;
    }
  }
  return true;
}
</script>
</body>
</html>
