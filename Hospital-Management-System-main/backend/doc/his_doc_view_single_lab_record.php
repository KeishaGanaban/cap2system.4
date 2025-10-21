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
    <!-- Sidebar -->
    <?php include('assets/inc/sidebar.php'); ?>

    <?php
    $lab_number = $_GET['lab_number'];
    $lab_id = $_GET['lab_id'];
    $ret = "SELECT * FROM his_laboratory WHERE lab_id = ?";
    $stmt = $mysqli->prepare($ret);
    $stmt->bind_param('i', $lab_id);
    $stmt->execute();
    $res = $stmt->get_result();

    while ($row = $res->fetch_object()) {
        $lab_date = $row->lab_date_rec ?? '';
    ?>

    <div class="content-page">
        <div class="content">

            <div class="container py-4">

                <!-- Page Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fw-bold text-primary mb-0">Laboratory Record #<?php echo htmlspecialchars($row->lab_number); ?></h3>
                    <div>
                        <a href="javascript:window.print()" class="btn btn-outline-primary btn-sm">
                            <i class="mdi mdi-printer"></i> Print Record
                        </a>
                    </div>
                </div>

                <!-- Patient Info Card -->
                <div class="card shadow-lg rounded-4 border-0 mb-4">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-4 text-center mb-3 mb-md-0">
                                <img src="assets/images/medical_record.png" class="img-fluid rounded-circle shadow-sm" style="width:160px; height:160px; object-fit:cover;" alt="Patient">
                                <h6 class="text-secondary mt-2">#<?php echo htmlspecialchars($row->lab_number); ?></h6>
                            </div>

                            <div class="col-md-8">
                                <h4 class="fw-bold mb-3"><?php echo htmlspecialchars($row->lab_pat_name); ?></h4>

                                <div class="row g-2">
                                    <div class="col-6">
                                        <span class="text-muted d-block">Patient Number</span>
                                        <h6 class="fw-semibold"><?php echo htmlspecialchars($row->lab_pat_number); ?></h6>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-muted d-block">Condition</span>
                                        <h6 class="fw-semibold">
                                            <span class="badge bg-danger">
                                                <?php echo !empty($row->lab_pat_condition) ? htmlspecialchars($row->lab_pat_condition) : 'Not specified'; ?>
                                            </span>
                                        </h6>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-muted d-block">Date Recorded</span>
                                        <h6 class="fw-semibold"><?php echo !empty($lab_date) ? date("d/m/Y - H:i:s", strtotime($lab_date)) : 'Not specified'; ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-3">

                        <!-- Laboratory Tests -->
                        <h5 class="fw-bold text-success mb-2"><i class="mdi mdi-flask"></i> Laboratory Test</h5>
                        <div class="bg-light p-3 rounded-3 mb-3 shadow-sm">
                            <p class="mb-0"><?php echo !empty($row->lab_pat_tests) ? nl2br(htmlspecialchars($row->lab_pat_tests)) : 'No tests recorded'; ?></p>
                        </div>

                        <!-- Laboratory Results -->
                        <h5 class="fw-bold text-success mb-2"><i class="mdi mdi-clipboard-check"></i> Laboratory Results</h5>
                        <div class="bg-light p-3 rounded-3 shadow-sm">
                            <p class="mb-0"><?php echo !empty($row->lab_pat_results) ? nl2br(htmlspecialchars($row->lab_pat_results)) : 'No results recorded'; ?></p>
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
