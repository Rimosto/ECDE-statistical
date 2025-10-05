<?php
// index.php - ECDE Data Management Portal
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ECDE Data Management Portal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: #f3f6f9;
            font-family: 'Poppins', sans-serif;
        }
        .navbar {
            background-color: #198754;
        }
        .navbar-brand, .nav-link {
            color: white !important;
        }
        .container {
            margin-top: 80px;
            text-align: center;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.2s ease-in-out;
        }
        .card:hover {
            transform: scale(1.03);
        }
        .btn-custom {
            background-color: #198754;
            color: white;
            border-radius: 50px;
        }
        .btn-custom:hover {
            background-color: #146c43;
        }
        footer {
            margin-top: 100px;
            background: #198754;
            color: white;
            padding: 10px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#"> Naivasha ECDE Portal</a>
  </div>
</nav>

<div class="container">
    <h1 class="fw-bold text-success mb-4">Welcome to the ECDE Data Management Portal</h1>
    <p class="lead text-muted mb-5">Submit, manage, and export ECDE school data efficiently.</p>

    <div class="row justify-content-center">
        <div class="col-md-4 mb-4">
            <div class="card p-4">
                <h4 class="fw-bold mb-3">Submit New Form</h4>
                <p>Enter a new ECDE school data record.</p>
                <a href="form.php" class="btn btn-custom px-4">Go to Form</a>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card p-4">
                <h4 class="fw-bold mb-3">Dashboard</h4>
                <p>View and export existing ECDE data.</p>
                <a href="dashboard.php" class="btn btn-custom px-4">View Dashboard</a>
            </div>
        </div>
    </div>
</div>

<footer class="text-center">
    <p>&copy; <?php echo date('Y'); ?> ECDE Data Management System | Developed by Rimosto</p>
</footer>

</body>
</html>

