
<?php
  session_start();
  include('assets/inc/config.php');
  include('assets/inc/checklogin.php');
  check_login();
  $pat_id = $_SESSION['pat_id'];
  $pat_number = $_SESSION['pat_number'];
?>

<!DOCTYPE html>
    <html lang="en">

    <?php include('assets/inc/head.php');?>

    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
             <?php include("assets/inc/nav.php");?>
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
                <?php include("assets/inc/sidebar.php");?>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <!--Get Details Of A Single User And Display Them Here-->
            <?php
                $pat_number = $_SESSION['pat_number'];
                $ret = "SELECT * FROM his_patients WHERE pat_number = ?";
                $stmt = $mysqli->prepare($ret);
                $stmt->bind_param('s', $pat_number); // ✅ use 's' (string)
                $stmt->execute();
                $res = $stmt->get_result();

                while ($row = $res->fetch_object()) {
            ?>

            ?>
            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title"><?php echo $row->pat_fname;?> <?php echo $row->pat_lname;?>'s Profile</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-lg-6 col-xl-6">
                                <div class="card-box text-center">
                                    <img src="../police/assets/images/users/<?php echo $row->pat_dpic;?>" class="rounded-circle avatar-lg img-thumbnail"
                                        alt="profile-image">

                                    
                                    <div class="text-centre mt-3">
                                        
                                        <p class="text-muted mb-2 font-13"><strong>Full Name :</strong> <span class="ml-2"><?php echo $row->pat_fname;?> <?php echo $row->pat_lname;?></span></p>
                                       <p class="text-muted mb-2 font-13"><strong>Rank/Position :</strong> <span class="ml-2"><?php echo $row->pat_position;?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Account Code :</strong> <span class="ml-2"><?php echo $row->pat_number;?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Station :</strong> <span class="ml-2"><?php echo $row->pat_location;?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Mobile :</strong><span class="ml-2"><?php echo $row->pat_phone; ?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span class="ml-2"><?php echo $row->pat_email;?></span></p>


                                    </div>

                                </div> <!-- end card-box -->
                            </div> <!-- end col-->
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
                                                    // ✅ Use session value instead of GET
                                                    $lab_pat_number = $_SESSION['pat_number'];

                                                    // ✅ Use a prepared statement safely
                                                    $ret = "SELECT * FROM his_laboratory WHERE lab_pat_number = ?";
                                                    $stmt = $mysqli->prepare($ret);
                                                    $stmt->bind_param('s', $lab_pat_number);
                                                    $stmt->execute();
                                                    $res = $stmt->get_result();

                                                    if ($res && $res->num_rows > 0) {
                                                        while ($row = $res->fetch_object()) {
                                                            $mysqlDateTime = $row->lab_date_rec; // trim timestamp to date
                                                ?>
                                                            <li class="timeline-sm-item">
                                                                <span class="timeline-sm-date"><?php echo date("Y-m-d", strtotime($mysqlDateTime));?></span>
                                                                <h3 class="mt-0 mb-1"><?php echo htmlspecialchars($row->lab_pat_condition); ?></h3>
                                                                <hr>
                                                                <h5>Laboratory Tests</h5>
                                                                <p class="text-muted mt-2">
                                                                    <?php
                                                                        $uploadedFileName = $row->lab_pat_tests;

                                                                        if (!empty($uploadedFileName)) {
                                                                            $downloadUrl = '../../download.php?file=' . urlencode($uploadedFileName);
                                                                            echo "<a href='$downloadUrl'>⬇️ Download Lab Test</a>";
                                                                        } else {
                                                                            echo "No uploaded file found.";
                                                                        }
                                                                    ?>
                                                                </p>
                                                                <hr>
                                                            </li>
                                                <?php
                                                        }
                                                    } else {
                                                        echo "<li><p class='text-muted'>No laboratory records found for this patient.</p></li>";
                                                    }
                                                ?>
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
                                                        echo "<tr><td colspan='5' class='text-muted text-center'>No checkups recorded</td></tr>";
                                                    }
                                                    ?>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            
                    </div> <!-- container -->

                </div> <!-- content -->

                <!-- Footer Start -->
                <?php include('assets/inc/footer.php');?>
                <!-- end Footer -->

            </div>
            <?php }?>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>

    </body>


</html>