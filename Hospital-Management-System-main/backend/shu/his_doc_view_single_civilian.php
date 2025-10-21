<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();

$doc_id = $_SESSION['doc_id'];

// Fetch doctor's name from session
$doc_query = "SELECT doc_fname, doc_lname FROM his_docs WHERE doc_id = ?";
$stmt_doc = $mysqli->prepare($doc_query);
$stmt_doc->bind_param('i', $doc_id);
$stmt_doc->execute();
$doc_result = $stmt_doc->get_result();
$doctor = $doc_result->fetch_object();
$doctor_name = "Dr. " . $doctor->doc_fname . " " . $doctor->doc_lname;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('assets/inc/head.php'); ?>
</head>

<body>

<!-- Begin page -->
<div id="wrapper">

    <!-- Topbar Start -->
    <?php include("assets/inc/nav.php"); ?>
    <!-- end Topbar -->

    <!-- Left Sidebar Start -->
    <?php include("assets/inc/sidebar.php"); ?>
    <!-- Left Sidebar End -->

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <?php
    $pat_number = $_GET['civ_number'];
    $pat_id = $_GET['civ_id'];
    $ret = "SELECT * FROM his_civillians WHERE civ_id=?";
    $stmt = $mysqli->prepare($ret);
    $stmt->bind_param('i', $pat_id);
    $stmt->execute();
    $res = $stmt->get_result();

    while ($row = $res->fetch_object()) {
        $mysqlDateTime = $row->civ_date_joined;
    ?>
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">

                <!-- Page Title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="his_doc_dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="his_doc_manage_patient.php">Police Registration</a></li>
                                    <li class="breadcrumb-item active">Manage Civilians</li>
                                </ol>
                            </div>
                            <h4 class="page-title"><?php echo $row->civ_fname . " " . $row->civ_lname; ?>'s Profile</h4>
                        </div>
                    </div>
                </div>

                <!-- Patient Info -->
                <div class="row">
                    <div class="col-lg-4 col-xl-4">
                        <div class="card-box text-center">
                            <img src="assets/images/users/patient.png" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">

                            <div class="text-left mt-3">
                                <p class="text-muted mb-2 font-13"><strong>Full Name :</strong> <span class="ml-2"><?php echo $row->civ_fname . " " . $row->civ_lname; ?></span></p>
                                <p class="text-muted mb-2 font-13"><strong>Mobile :</strong><span class="ml-2"><?php echo $row->civ_phone; ?></span></p>
                                <p class="text-muted mb-2 font-13"><strong>Date Of Birth :</strong> <span class="ml-2"><?php echo $row->civ_dob; ?></span></p>
                                <p class="text-muted mb-2 font-13"><strong>Age :</strong> <span class="ml-2"><?php echo $row->civ_age; ?> Years</span></p>
                                <p class="text-muted mb-2 font-13"><strong>Sex :</strong> <span class="ml-2"><?php echo $row->civ_type; ?></span></p>
                                <p class="text-muted mb-2 font-13"><strong>Location :</strong> <span class="ml-2"><?php echo $row->civ_location; ?></span></p>
                                <p class="text-muted mb-2 font-13"><strong>Condition :</strong> <span class="ml-2"><?php echo htmlspecialchars($row->civ_conditions);?></span></p>
                                <p class="text-muted mb-2 font-13"><strong>Symptoms :</strong> <span class="ml-2"><?php echo htmlspecialchars($row->civ_symptoms);?></span></p>
                                <hr>
                                <p class="text-muted mb-2 font-13"><strong>Date Recorded :</strong> <span class="ml-2"><?php echo date("d/m/Y - h:i A", strtotime($mysqlDateTime)); ?></span></p>
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                    <!-- Right Side Tabs -->
                    <div class="col-lg-8 col-xl-8">
                        <div class="card-box">
                            <ul class="nav nav-pills navtab-bg nav-justified">
                                <li class="nav-item">
                                    <a href="#diagnosis" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                        Diagnosis
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content">

                                <!-- Diagnosis Tab -->
                                <div class="tab-pane show active" id="diagnosis">
                                    <div class="section-header mb-3">
                                        <h4><i class="mdi mdi-stethoscope text-primary"></i> Diagnosis Records</h4>
                                        <hr>
                                    </div>

                                    <ul class="list-unstyled timeline-sm">
                                        <?php
                                        $ret = "SELECT pres_pat_diagnosis, pres_ins, pres_date
                                                FROM his_prescriptions
                                                WHERE pres_pat_number = ?
                                                ORDER BY pres_date DESC";
                                        $stmt = $mysqli->prepare($ret);
                                        $stmt->bind_param('s', $pat_number);
                                        $stmt->execute();
                                        $res = $stmt->get_result();
                                        $index = 0;

                                        if ($res->num_rows > 0) {
                                            while ($row = $res->fetch_object()) {
                                                $mysqlDateTime = $row->pres_date;
                                                $bgColor = ($index % 2 == 0) ? "#f8f9fa" : "#eef6ff";
                                                $index++;
                                        ?>
                                                <li class="timeline-sm-item">
                                                    <div class="card shadow-sm border-0 mb-3 p-3"
                                                         style="background: <?php echo $bgColor; ?>; border-left: 5px solid #007bff; border-radius: 10px;">
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <h5 class="text-primary mb-0"><i class="mdi mdi-stethoscope"></i> Diagnosis</h5>
                                                            <span class="badge bg-light text-dark"><?php echo date("Y-m-d", strtotime($mysqlDateTime)); ?></span>
                                                        </div>
                                                        <p class="text-muted mb-1"><b>Diagnosis:</b> <?php echo htmlspecialchars($row->pres_pat_diagnosis); ?></p>
                                                        <p class="text-muted mb-1"><b>Doctor:</b> <?php echo $doctor_name; ?></p>
                                                        <p class="text-muted mb-0"><b>Remarks:</b> <?php echo nl2br(htmlspecialchars($row->pres_ins)); ?></p>
                                                    </div>
                                                </li>
                                        <?php
                                            }
                                        } else {
                                            echo "<li><p class='text-muted'>No diagnosis records found for this patient.</p></li>";
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- container -->
        </div> <!-- content -->

        <?php include('assets/inc/footer.php'); ?>
    </div>

</div>
<!-- END wrapper -->

<!-- Scripts -->
<script src="assets/js/vendor.min.js"></script>
<script src="assets/js/app.min.js"></script>

<!-- Style -->
<style>
.section-header h4 {
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
}
.card:hover {
    transform: translateY(-3px);
    transition: 0.25s ease;
    box-shadow: 0 6px 12px rgba(0,0,0,0.12);
}
.badge.bg-light {
    background-color: #f1f3f5 !important;
    border: 1px solid #dee2e6;
}
.timeline-sm-item {
    list-style: none;
}
</style>

</body>
</html>
