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

                <!-- Page Title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="his_doc_dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="his_doc_manage_patient.php">Patients</a></li>
                                    <li class="breadcrumb-item active">View Patient</li>
                                </ol>
                            </div>
                            <h4 class="page-title"><?php echo $row->pat_fname . " " . $row->pat_lname; ?>'s Profile</h4>
                        </div>
                    </div>
                </div>

                <!-- Patient Info -->
                <div class="row">
                    <div class="col-lg-4 col-xl-4">
                        <div class="card-box text-center">
                            <img src="assets/images/users/patient.png" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">

                            <div class="text-left mt-3">
                                <p class="text-muted mb-2 font-13"><strong>Full Name :</strong> <span class="ml-2"><?php echo $row->pat_fname . " " . $row->pat_lname; ?></span></p>
                                <p class="text-muted mb-2 font-13"><strong>Mobile :</strong><span class="ml-2"><?php echo $row->pat_phone; ?></span></p>
                                <p class="text-muted mb-2 font-13"><strong>Address :</strong> <span class="ml-2"><?php echo $row->pat_addr; ?></span></p>
                                <p class="text-muted mb-2 font-13"><strong>Rank :</strong> <span class="ml-2"><?php echo $row->pat_position; ?></span></p>
                                <p class="text-muted mb-2 font-13"><strong>Date Of Birth :</strong> <span class="ml-2"><?php echo $row->pat_dob; ?></span></p>
                                <p class="text-muted mb-2 font-13"><strong>Age :</strong> <span class="ml-2"><?php echo $row->pat_age; ?> Years</span></p>
                                <p class="text-muted mb-2 font-13"><strong>Location :</strong> <span class="ml-2"><?php echo $row->pat_location; ?></span></p>
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
                                <li class="nav-item">
                                    <a href="#vitals" data-toggle="tab" aria-expanded="true" class="nav-link">
                                        Vitals
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#lab" data-toggle="tab" aria-expanded="false" class="nav-link">
                                        Lab Records
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#checkup" data-toggle="tab" aria-expanded="false" class="nav-link">
                                        Checkups
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

                                <!-- Vitals Tab -->
                                <div class="tab-pane" id="vitals">
                                    <div class="section-header mb-3">
                                        <h4><i class="mdi mdi-heart-pulse text-danger"></i> Vitals</h4>
                                        <hr>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-borderless mb-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th><i class="mdi mdi-thermometer"></i> Temp</th>
                                                    <th><i class="mdi mdi-heart"></i> Pulse</th>
                                                    <th><i class="mdi mdi-weather-windy"></i> Resp</th>
                                                    <th><i class="mdi mdi-water"></i> BP</th>
                                                    <th><i class="mdi mdi-calendar"></i> Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $ret = "SELECT * FROM his_vitals WHERE vit_pat_number = ? ORDER BY vit_daterec DESC";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->bind_param('s', $pat_number);
                                                $stmt->execute();
                                                $res = $stmt->get_result();
                                                $index = 0;

                                                if ($res->num_rows > 0) {
                                                    while ($row = $res->fetch_object()) {
                                                        $mysqlDateTime = $row->vit_daterec;
                                                        $bgColor = ($index % 2 == 0) ? "#f8f9fa" : "#eef6ff";
                                                        $index++;
                                                ?>
                                                        <tr style="background: <?php echo $bgColor; ?>;">
                                                            <td><?php echo $row->vit_bodytemp; ?> °C</td>
                                                            <td><?php echo $row->vit_heartpulse; ?> BPM</td>
                                                            <td><?php echo $row->vit_resprate; ?> bpm</td>
                                                            <td><?php echo $row->vit_bloodpress; ?> mmHg</td>
                                                            <td><?php echo date("Y-m-d", strtotime($mysqlDateTime)); ?></td>
                                                        </tr>
                                                <?php
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='5' class='text-muted text-center'>No vitals found.</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Lab Records Tab -->
                                <div class="tab-pane" id="lab">
                                    <div class="section-header mb-3">
                                        <h4><i class="mdi mdi-flask-outline text-success"></i> Laboratory Reports</h4>
                                        <hr>
                                    </div>

                                    <ul class="list-unstyled timeline-sm">
                                        <?php
                                            $lab_pat_number =$_GET['pat_number'];
                                            $ret="SELECT  * FROM his_laboratory WHERE  	lab_pat_number  ='$lab_pat_number'";
                                            $stmt= $mysqli->prepare($ret) ;
                                            // $stmt->bind_param('i',$lab_pat_number);
                                            $stmt->execute() ;//ok
                                            $res=$stmt->get_result();
                                            //$cnt=1;
                                            
                                            while($row=$res->fetch_object())
                                                {
                                            $mysqlDateTime = $row->lab_date_rec; //trim timestamp to date

                                        ?>
                                            <li class="timeline-sm-item">
                                                <span class="timeline-sm-date"><?php echo date("Y-m-d", strtotime($mysqlDateTime));?></span>
                                                <h3 class="mt-0 mb-1"><?php echo $row->lab_pat_ailment;?></h3>
                                                <hr>
                                                <h5>
                                                   Laboratory  Tests
                                                </h5>
                                                        
                                                <p class="text-muted mt-2">
                                                    <?php
                                                        $uploadedFileName = $row->lab_pat_tests; // adjust field name accordingly

                                                        if ($uploadedFileName) {
                                                            $downloadUrl = '../../download.php?file=' . urlencode($uploadedFileName);
                                                            echo "<a href='$downloadUrl'>⬇️ Download Lab Test</a>";
                                                        } else {
                                                            echo "No uploaded file found.";
                                                        }
                                                    ?>
                                                </p>
                                            <hr>
                                            </li>
                                        <?php }?>
                                    </ul>
                                </div>

                                <!-- Checkup Tab -->
                                 <div class="tab-pane" id="checkup">
                                    <div class="section-header mb-3">
                                        <h4><i class="mdi mdi-stethoscope text-primary"></i> Checkups</h4>
                                        <hr>
                                    </div>

                                    <div class="text-left mt-3">
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
                                                    <p class="text-muted mb-2 font-13"><strong>Symptom Duration :</strong> <span class="ml-2"><?php echo $row->symptom_duration; ?></span></p>
                                                    <p class="text-muted mb-2 font-13"><strong>Condition :</strong> <span class="ml-2"><?php echo htmlspecialchars($row->cons); ?></span></p>
                                                    <p class="text-muted mb-2 font-13"><strong>Diagnosed Allergies :</strong> <span class="ml-2"><?php echo $row->diagnosed_allergies; ?></span></p>
                                                    <p class="text-muted mb-2 font-13"><strong>Date Requested :</strong> <span class="ml-2"><?php echo $row->check_rd; ?></span></p>
                                                    <hr>
                                                    <p class="text-muted mb-2 font-13"><strong>Date Recorded :</strong> <span class="ml-2"><?php echo date("d/m/Y - h:i A", strtotime($mysqlDateTime)); ?></span></p>
                                            <?php
                                                }
                                            } else {
                                                echo "<tr><td colspan='5' class='text-muted text-center'>No vitals found.</td></tr>";
                                            }
                                            ?>
                                    </div>
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
