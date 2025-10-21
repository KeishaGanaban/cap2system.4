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

<body>
    <div id="wrapper">
        <?php include("assets/inc/nav.php"); ?>
        <?php include("assets/inc/sidebar.php"); ?>

        <?php
        $pat_number = $_GET['pat_number'];
        $pat_id = $_GET['pat_id'];
        $ret = "SELECT * FROM his_patients WHERE pat_id=?";
        $stmt = $mysqli->prepare($ret);
        $stmt->bind_param('i', $pat_id);
        $stmt->execute();
        $res = $stmt->get_result();

        while ($row = $res->fetch_object()) {
            $mysqlDateTime = $row->pat_date_joined;
        ?>
            <div class="content-page">
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="javascript:void(0);">Patients</a></li>
                                            <li class="breadcrumb-item active">View Patient</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title"><?php echo $row->pat_fname . ' ' . $row->pat_lname; ?>'s Profile</h4>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- LEFT COLUMN -->
                            <div class="col-lg-4 col-xl-4">
                                <div class="card-box text-center">
                                    <img src="assets/images/users/patient.png" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">

                                    <div class="text-left mt-3">
                                        <p class="text-muted mb-2 font-13"><strong>Full Name :</strong> <span class="ml-2"><?php echo $row->pat_fname . ' ' . $row->pat_lname; ?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Mobile :</strong> <span class="ml-2"><?php echo $row->pat_phone; ?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Address :</strong> <span class="ml-2"><?php echo $row->pat_addr; ?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Date Of Birth :</strong> <span class="ml-2"><?php echo $row->pat_dob; ?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Age :</strong> <span class="ml-2"><?php echo $row->pat_age; ?> Years</span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Sex :</strong> <span class="ml-2"><?php echo $row->pat_type; ?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Rank :</strong> <span class="ml-2"><?php echo $row->pat_position; ?></span></p>
                                        <hr>
                                        <p class="text-muted mb-2 font-13"><strong>Date Recorded :</strong>
                                            <span class="ml-2"><?php echo date("d/m/Y - h:i A", strtotime($mysqlDateTime)); ?></span>
                                        </p>
                                        <hr>

                                        <!-- Diagnosis Notes Container -->
                                        <?php
                                        // Fetch latest diagnosis for this patient
                                        $pres_pat_number = $_GET['pat_number']; // or $row->pat_number depending on your setup
                                        $latest = null;

                                        $ret_latest = "SELECT pres_pat_diagnosis, pres_ins, pres_date 
                                                    FROM his_prescriptions 
                                                    WHERE pres_pat_number = ? 
                                                    ORDER BY pres_date DESC LIMIT 1";
                                        $stmt_latest = $mysqli->prepare($ret_latest);
                                        $stmt_latest->bind_param('s', $pres_pat_number);
                                        $stmt_latest->execute();
                                        $res_latest = $stmt_latest->get_result();

                                        if ($res_latest->num_rows > 0) {
                                            $latest = $res_latest->fetch_object();
                                        }
                                        ?>

                                        <?php if ($latest): ?>
                                            <?php
                                            // Detect condition severity for color badge
                                            $diagnosis_text = strtolower($latest->pres_pat_diagnosis);
                                            $badge_color = "secondary";
                                            if (strpos($diagnosis_text, 'critical') !== false || strpos($diagnosis_text, 'severe') !== false) $badge_color = "danger";
                                            elseif (strpos($diagnosis_text, 'stable') !== false) $badge_color = "success";
                                            elseif (strpos($diagnosis_text, 'moderate') !== false) $badge_color = "warning";
                                            ?>
                                            
                                            <div class="card mt-2 p-2" style="background-color:#f9f9fb; border:1px solid #e0e0e0; border-radius:6px;">
                                                <h6 class="text-primary mb-1" style="font-size:0.9rem;">
                                                    <i class="bi bi-clipboard2-pulse me-1"></i> Latest Diagnosis
                                                </h6>
                                                <p class="mb-1">
                                                    <span class="badge bg-<?php echo $badge_color; ?>">
                                                        <?php echo htmlspecialchars($latest->pres_pat_diagnosis); ?>
                                                    </span>
                                                </p>
                                                <p class="mb-0"><strong>Notes:</strong> <?php echo $latest->pres_ins; ?></p>
                                                <small class="text-muted">Recorded on: <?php echo date("Y-m-d", strtotime($latest->pres_date)); ?></small>
                                            </div>

                                        <?php else: ?>
                                            <div class="card mt-2 p-2" style="background-color:#f9f9fb; border:1px solid #e0e0e0; border-radius:6px;">
                                                <h6 class="text-primary mb-1" style="font-size:0.9rem;">
                                                    <i class="bi bi-clipboard2-pulse me-1"></i> Latest Diagnosis
                                                </h6>
                                                <p class="text-muted small mb-0">No diagnosis recorded yet.</p>
                                            </div>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            </div>
                            <!-- END LEFT COLUMN -->

                            <!-- RIGHT COLUMN -->
                            <div class="col-lg-8 col-xl-8">
                                <div class="card-box">
                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="aboutme">
                                            <ul class="list-unstyled timeline-sm"></ul>

                                            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
                                            <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

                                            <style>
                                                body { background-color: #f8f9fa; font-size: 0.8rem; }
                                                .card { border: 1px solid #ddd; border-radius: 8px; font-size: 0.8rem; box-shadow: 0 1px 3px rgba(0,0,0,0.05); margin-bottom: 1rem; }
                                                .card-header { background-color: #f1f3f5; padding: 0.4rem 0.75rem; }
                                                .card-header h4 { font-size: 0.95rem; font-weight: 600; margin: 0; color: #333; }
                                                .card-body { padding: 0.75rem; }
                                                table th, table td { font-size: 0.75rem; padding: 0.3rem 0.4rem; vertical-align: middle; }
                                                .lab-box { background: #fff; border: 1px solid #eee; border-radius: 6px; padding: 0.6rem 0.8rem; margin-bottom: 0.75rem; }
                                                .lab-box h6 { font-size: 0.85rem; margin: 0 0 0.3rem 0; font-weight: 600; color: #333; }
                                                .lab-box p { margin: 0; font-size: 0.78rem; color: #555; }
                                            </style>

                                            <div class="container py-1" style="max-width: 900px;">
                                                <!-- ================== VITAL SIGNS ================== -->
                                                <div class="card">
                                                    <div class="card-header d-flex align-items-center">
                                                        <i class="bi bi-heart-pulse text-danger me-1"></i>
                                                        <h4 class="mb-0">Patient Vital Signs</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-sm table-bordered align-middle">
                                                                <thead class="table-light">
                                                                    <tr>
                                                                        <th>Body Temp (°C)</th>
                                                                        <th>Heart Rate (BPM)</th>
                                                                        <th>Resp Rate (bpm)</th>
                                                                        <th>Blood Pressure</th>
                                                                        <th>Date</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $vit_pat_number = $_GET['pat_number'];
                                                                    $ret = "SELECT * FROM his_vitals WHERE vit_pat_number = ?";
                                                                    $stmt = $mysqli->prepare($ret);
                                                                    $stmt->bind_param('s', $vit_pat_number);
                                                                    $stmt->execute();
                                                                    $res_vit = $stmt->get_result();

                                                                    if ($res_vit->num_rows > 0) {
                                                                        while ($v = $res_vit->fetch_object()) {
                                                                            $mysqlDateTime = $v->vit_daterec;
                                                                    ?>
                                                                            <tr>
                                                                                <td><?php echo $v->vit_bodytemp; ?></td>
                                                                                <td><?php echo $v->vit_heartpulse; ?></td>
                                                                                <td><?php echo $v->vit_resprate; ?></td>
                                                                                <td><?php echo $v->vit_bloodpress; ?></td>
                                                                                <td><?php echo date("Y-m-d", strtotime($mysqlDateTime)); ?></td>
                                                                            </tr>
                                                                    <?php
                                                                        }
                                                                    } else {
                                                                        echo '<tr><td colspan="5" class="text-center text-muted small">No vitals recorded</td></tr>';
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- ================== LABORATORY TESTS ================== -->
                                                <div class="card">
                                                    <div class="card-header d-flex align-items-center">
                                                        <i class="bi bi-list-check text-warning me-2"></i>
                                                        <h4 class="mb-0">Laboratory Tests</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <?php
                                                        $lab_pat_number = $_GET['pat_number'];
                                                        $ret = "SELECT * FROM his_laboratory WHERE lab_pat_number = ?";
                                                        $stmt = $mysqli->prepare($ret);
                                                        $stmt->bind_param('s', $lab_pat_number);
                                                        $stmt->execute();
                                                        $res_lab = $stmt->get_result();

                                                        if ($res_lab->num_rows > 0) {
                                                            while ($l = $res_lab->fetch_object()) {
                                                        ?>
                                                                <div class="lab-box">
                                                                    <div class="d-flex justify-content-between">
                                                                        <small class="text-muted"><?php echo date("Y-m-d", strtotime($l->lab_date_rec)); ?></small>
                                                                    </div>
                                                                    <p><strong>Performed Tests:</strong> <?php echo nl2br(htmlspecialchars($l->lab_pat_tests)); ?></p>

                                                                    <?php if (!empty($l->lab_test_file)): ?>
                                                                        <a href="assets/uploads/laboratory/<?php echo htmlspecialchars($l->lab_test_file); ?>" 
                                                                        class="btn btn-sm btn-outline-primary mt-1" download>
                                                                            <i class="bi bi-download me-1"></i> Download File
                                                                        </a>
                                                                    <?php else: ?>
                                                                        <p class="text-muted small mb-0"><em>No file uploaded</em></p>
                                                                    <?php endif; ?>
                                                                </div>
                                                        <?php
                                                            }
                                                        } else {
                                                            echo '<p class="text-muted small text-center mb-0">No laboratory tests available.</p>';
                                                        }
                                                        ?>
                                                    </div>
                                                </div>

                                                <!-- ================== CHECKUP ================== -->
                                                <div class="card">
                                                    <div class="card-header d-flex align-items-center">
                                                        <i class="bi bi-clipboard2-pulse text-success me-2"></i>
                                                        <h4 class="mb-0">Checkup Results</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <?php
                                                            $ret = "SELECT * FROM his_checkup WHERE check_pat_number = ? ORDER BY check_daterec DESC";
                                                            $stmt = $mysqli->prepare($ret);
                                                            $stmt->bind_param('s', $pat_number);
                                                            $stmt->execute();
                                                            $res = $stmt->get_result();
                                                            $index = 0;

                                                            if ($res->num_rows > 0) {
                                                                while ($row = $res->fetch_object()) {
                                                                    $mysqlDateTime = $row->check_daterec;
                                                                    $bgColor = ($index % 2 == 0) ? "#f8f9fa" : "#eef6ff";
                                                                    $index++;                                                ?>
                                                                    <p class="text-muted mb-2 font-13"><strong>Symptoms :</strong> <span class="ml-2"><?php echo htmlspecialchars($row->symptoms); ?></span></p>
                                                                    <p class="text-muted mb-2 font-13"><strong>Symptom Duration :</strong> <span class="ml-2"><?php echo $row->symptom_duration; ?> Days</span></p>
                                                                    <p class="text-muted mb-2 font-13"><strong>Condition :</strong> <span class="ml-2"><?php echo htmlspecialchars($row->cons); ?></span></p>
                                                                    <p class="text-muted mb-2 font-13"><strong>Diagnosed Allergies :</strong> <span class="ml-2"><?php echo $row->diagnosed_allergies; ?></span></p>
                                                                    <p class="text-muted mb-2 font-13"><strong>Date Requested :</strong> <span class="ml-2"><?php echo $row->check_rd; ?></span></p>
                                                                    <hr>
                                                                    <p class="text-muted mb-2 font-13"><strong>Date Recorded :</strong> <span class="ml-2"><?php echo date("d/m/Y - h:i A", strtotime($mysqlDateTime)); ?></span></p>
                                                            <?php
                                                                }
                                                            } else {
                                                                echo "<tr><td colspan='5' class='text-muted text-center'>No checkups recorded</td></tr>";
                                                            }
                                                            ?>
                                                    </div>
                                                </div>

                                                <!-- ================== PRESCRIPTION RESULTS ================== -->
                                                <div class="card">
                                                    <div class="card-header d-flex align-items-center">
                                                        <i class="bi bi-capsule text-success me-2"></i>
                                                        <h4 class="mb-0">Prescription Results</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <?php
                                                        $ret = "SELECT pres_pat_diagnosis, pres_ins, pres_date FROM his_prescriptions WHERE pres_pat_number = ? ORDER BY pres_id DESC";
                                                        $stmt = $mysqli->prepare($ret);
                                                        $stmt->bind_param('s', $pres_pat_number);
                                                        $stmt->execute();
                                                        $res_pres = $stmt->get_result();

                                                        if ($res_pres->num_rows > 0) {
                                                            while ($p = $res_pres->fetch_object()) {
                                                        ?>
                                                                <div class="lab-box">
                                                                    <div class="d-flex justify-content-between">
                                                                        <small class="text-muted"><?php echo date("Y-m-d", strtotime($p->pres_date)); ?></small>
                                                                    </div>
                                                                    <p class="mb-0"><strong>Prescription:</strong> 
                                                                        <?php echo nl2br(strip_tags($p->pres_ins)); ?>
                                                                    </p>
                                                                </div>
                                                        <?php
                                                            }
                                                        } else {
                                                            echo '<p class="text-muted small text-center mb-0">No prescription records found.</p>';
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END RIGHT COLUMN -->
                        </div>
                    </div>
                </div>
                <?php include('assets/inc/footer.php'); ?>
            </div>
        <?php } ?>
    </div>

    <div class="rightbar-overlay"></div>
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>
</body>
</html>
