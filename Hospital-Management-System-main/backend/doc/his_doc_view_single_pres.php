<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();
$doc_id = $_SESSION['doc_id'];
?>

<!DOCTYPE html>
<html lang="en">
<?php include('assets/inc/head.php'); ?>

<body class="bg-light">

<div id="wrapper">

    <!-- Topbar -->
    <?php include('assets/inc/nav.php'); ?>
    <?php include("assets/inc/sidebar.php"); ?>

    <?php
    $pres_number = $_GET['pres_number'];
    $pres_id = $_GET['pres_id'];

    $ret = "SELECT * FROM his_prescriptions WHERE pres_number = ? AND pres_id = ?";
    $stmt = $mysqli->prepare($ret);
    $stmt->bind_param('ii', $pres_number, $pres_id);
    $stmt->execute();
    $res = $stmt->get_result();

    while ($row = $res->fetch_object()) {
    ?>
    <div class="content-page">
        <div class="content">

            <div class="container py-4">

                <!-- Page Header -->
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
                    <h3 class="fw-bold text-primary mb-2 mb-md-0">Prescription Details</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="his_doc_dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">View Prescription</li>
                        </ol>
                    </nav>
                </div>

                <!-- Prescription Card -->
                <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                    <div class="row g-0">

                        <!-- Left: Patient Image -->
                        <div class="col-md-4 bg-primary text-white text-center p-4">
                            <img src="assets/images/users/patient.png" alt="Patient"
                                 class="img-fluid rounded-circle shadow mb-3"
                                 style="width:160px; height:160px; object-fit:cover;">
                            <h5 class="fw-bold">#<?php echo $row->pres_number; ?></h5>
                            <span class="d-block mt-2"><?php echo htmlspecialchars($row->pres_pat_name); ?></span>
                        </div>

                        <!-- Right: Details -->
                        <div class="col-md-8 p-4">
                            <div class="row mb-3 g-3">
                                <div class="col-6 col-md-6">
                                    <i class="mdi mdi-cake text-muted me-2"></i>
                                    Age: <strong><?php echo $row->pres_pat_age; ?> Years</strong>
                                </div>
                                <div class="col-6 col-md-6">
                                    <i class="mdi mdi-account-box text-muted me-2"></i>
                                    Patient Number: <strong><?php echo $row->pres_pat_number; ?></strong>
                                </div>
                                <div class="col-6 col-md-6">
                                    <i class="mdi mdi-account-group text-muted me-2"></i>
                                    Type: <span class="badge bg-info"><?php echo $row->pres_pat_type; ?></span>
                                </div>
                                <div class="col-6 col-md-6">
                                    <i class="mdi mdi-alert-circle text-muted me-2"></i>
                                    Condition: <span class="badge bg-danger">
                                        <?php echo !empty($row->pres_pat_condition) ? htmlspecialchars($row->pres_pat_condition) : 'Not specified'; ?>
                                    </span>
                                </div>
                                <div class="col-12">
                                    <i class="mdi mdi-stethoscope text-muted me-2"></i>
                                    Diagnosis: <span class="badge bg-warning text-dark">
                                        <?php echo !empty($row->pres_pat_diagnosis) ? htmlspecialchars($row->pres_pat_diagnosis) : 'Not specified'; ?>
                                    </span>
                                </div>
                            </div>

                            <hr>

                            <!-- Prescription Notes -->
                            <h5 class="fw-bold text-success mb-2">
                                <i class="mdi mdi-pill me-1"></i> Prescription Notes
                            </h5>
                            <div class="bg-light border rounded-4 p-4" style="min-height:140px; font-size:1rem; line-height:1.6;">
                                <?php
                                // Safely render stored notes with basic HTML (<p>, <br>, <strong>, <em>)
                                echo !empty($row->pres_ins) ? strip_tags($row->pres_ins, '<p><br><strong><em>') : '<p>No notes available.</p>';
                                ?>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Footer -->
        <?php include('assets/inc/footer.php'); ?>
    </div>
    <?php } ?>

</div>

<!-- Scripts -->
<script src="assets/js/vendor.min.js"></script>
<script src="assets/js/app.min.js"></script>

</body>
</html>
