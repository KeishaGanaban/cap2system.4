<?php
  session_start();
  include('assets/inc/config.php');
  include('assets/inc/checklogin.php');
  check_login();
  $aid=$_SESSION['ad_id'];
?>
<!DOCTYPE html>
<html lang="en">
    
    <!--Head Code-->
    <?php include("assets/inc/head.php");?>

    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
            <?php include('assets/inc/nav.php');?>
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
            <?php include('assets/inc/sidebar.php');?>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">PNP - CAR PATIENT MANAGEMENT SYSTEM</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <!-- Stat Cards -->
                        <!-- Stat Cards -->
            <div class="row">
                <!-- Total Patients -->
                <div class="col-md-6 col-xl-3">
                    <div class="widget-rounded-circle card-box">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                                    <i class="mdi mdi-hospital-building font-22 avatar-title text-primary"></i>
                                </div>
                            </div>
                            <div class="col-6 text-right">
                                <?php
                                    // This Week
                                    $stmt = $mysqli->prepare("SELECT COUNT(*) FROM his_patients WHERE YEARWEEK(pat_date_joined,1)=YEARWEEK(CURDATE(),1)");
                                    $stmt->execute(); $stmt->bind_result($thisWeek); $stmt->fetch(); $stmt->close();

                                    // Last Week
                                    $stmt = $mysqli->prepare("SELECT COUNT(*) FROM his_patients WHERE YEARWEEK(pat_date_joined,1)=YEARWEEK(CURDATE(),1)-1");
                                    $stmt->execute(); $stmt->bind_result($lastWeek); $stmt->fetch(); $stmt->close();

                                    $totalPatients = $thisWeek; 
                                    $change = $lastWeek > 0 ? (($thisWeek - $lastWeek) / $lastWeek) * 100 : 0;
                                    $arrow = $thisWeek > $lastWeek ? "▲" : ($thisWeek < $lastWeek ? "▼" : "➝");
                                    $color = $thisWeek > $lastWeek ? "text-success" : ($thisWeek < $lastWeek ? "text-danger" : "text-warning");
                                ?>
                                <h3 class="text-dark mt-1"><?php echo $totalPatients; ?></h3>
                                <p class="mb-0 <?php echo $color; ?>"><?php echo $arrow . " " . number_format($change,1) . "%"; ?></p>
                                <p class="text-muted mb-1">Total Patients</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Patients -->
                <div class="col-md-6 col-xl-3">
                    <div class="widget-rounded-circle card-box">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-lg rounded-circle bg-soft-success border-success border">
                                    <i class="mdi mdi-account-heart font-22 avatar-title text-success"></i>
                                </div>
                            </div>
                            <div class="col-6 text-right">
                                <?php
                                    $stmt = $mysqli->prepare("SELECT COUNT(*) FROM his_patients WHERE pat_discharge_status='Active'");
                                    $stmt->execute(); $stmt->bind_result($active); $stmt->fetch(); $stmt->close();
                                ?>
                                <h3 class="text-dark mt-1"><?php echo $active; ?></h3>
                                <p class="mb-0 text-muted">Current</p>
                                <p class="text-muted mb-1">Active Patients</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Diagnosed Patients -->
                <div class="col-md-6 col-xl-3">
                    <div class="widget-rounded-circle card-box">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-lg rounded-circle bg-soft-danger border-danger border">
                                    <i class="mdi mdi-account-off font-22 avatar-title text-danger"></i>
                                </div>
                            </div>
                            <div class="col-6 text-right">
                                <?php
                                    $stmt = $mysqli->prepare("SELECT COUNT(*) FROM his_patients WHERE pat_discharge_status='Diagnosed'");
                                    $stmt->execute(); $stmt->bind_result($diagnosed); $stmt->fetch(); $stmt->close();
                                ?>
                                <h3 class="text-dark mt-1"><?php echo $diagnosed; ?></h3>
                                <p class="mb-0 text-muted">Current</p>
                                <p class="text-muted mb-1">Diagnosed Patients</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Employees -->
                <div class="col-md-6 col-xl-3">
                    <div class="widget-rounded-circle card-box">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-lg rounded-circle bg-soft-info border-info border">
                                    <i class="mdi mdi-doctor font-22 avatar-title text-info"></i>
                                </div>
                            </div>
                            <div class="col-6 text-right">
                                <?php
                                    $stmt = $mysqli->prepare("SELECT COUNT(*) FROM his_docs WHERE YEARWEEK(doc_date_joined,1)=YEARWEEK(CURDATE(),1)");
                                    $stmt->execute(); $stmt->bind_result($docsThisWeek); $stmt->fetch(); $stmt->close();

                                    $stmt = $mysqli->prepare("SELECT COUNT(*) FROM his_docs WHERE YEARWEEK(doc_date_joined,1)=YEARWEEK(CURDATE(),1)-1");
                                    $stmt->execute(); $stmt->bind_result($docsLastWeek); $stmt->fetch(); $stmt->close();

                                    $docs = $docsThisWeek; 
                                    $change = $docsLastWeek > 0 ? (($docsThisWeek - $docsLastWeek) / $docsLastWeek) * 100 : 0;
                                    $arrow = $docsThisWeek > $docsLastWeek ? "▲" : ($docsThisWeek < $docsLastWeek ? "▼" : "➝");
                                    $color = $docsThisWeek > $docsLastWeek ? "text-success" : ($docsThisWeek < $docsLastWeek ? "text-danger" : "text-warning");
                                ?>
                                <h3 class="text-dark mt-1"><?php echo $docs; ?></h3>
                                <p class="mb-0 <?php echo $color; ?>"><?php echo $arrow . " " . number_format($change,1) . "%"; ?></p>
                                <p class="text-muted mb-1">Employees</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            // Weekly Patients Query (using pat_date_joined instead of pat_dr)
            $weekLabels = [];
            $weekCounts = [];
            $query = "SELECT YEARWEEK(pat_date_joined, 1) AS week, COUNT(*) AS total 
                    FROM his_patients 
                    GROUP BY week 
                    ORDER BY week DESC 
                    LIMIT 6";
            $result = $mysqli->query($query);
            while ($row = $result->fetch_assoc()) {
                $weekLabels[] = "Week " . $row['week'];
                $weekCounts[] = $row['total'];
            }
            $weekLabels = array_reverse($weekLabels);
            $weekCounts = array_reverse($weekCounts);

            // Location Query
            $locationLabels = [];
            $locationCounts = [];
            $query = "SELECT pat_location, COUNT(*) AS total 
                    FROM his_patients 
                    GROUP BY pat_location 
                    ORDER BY total DESC 
                    LIMIT 5";
            $result = $mysqli->query($query);
            while ($row = $result->fetch_assoc()) {
                $locationLabels[] = $row['pat_location'];
                $locationCounts[] = $row['total'];
            }
            ?>

            </div>

            <!-- Chart.js -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
            // Weekly Chart
            var ctx = document.getElementById('patientsWeeklyChart').getContext('2d');
            var patientsWeeklyChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($weekLabels); ?>,
                    datasets: [{
                        label: 'New Patients',
                        data: <?php echo json_encode($weekCounts); ?>,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3
                    }]
                }
            });

            // Location Chart
            var ctx2 = document.getElementById('patientsLocationChart').getContext('2d');
            var patientsLocationChart = new Chart(ctx2, {
                type: 'doughnut',
                data: {
                    labels: <?php echo json_encode($locationLabels); ?>,
                    datasets: [{
                        data: <?php echo json_encode($locationCounts); ?>,
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(255, 206, 86, 0.7)',
                            'rgba(153, 102, 255, 0.7)'
                        ]
                    }]
                }
            });
            </script>


            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

        <!-- Right Sidebar -->
        <div class="right-bar">
            <div class="rightbar-title">
                <a href="javascript:void(0);" class="right-bar-toggle float-right">
                    <i class="dripicons-cross noti-icon"></i>
                </a>
                <h5 class="m-0 text-white">Settings</h5>
            </div>
            <div class="slimscroll-menu">
                <!-- User box -->
                <div class="user-box">
                    <div class="user-img">
                        <img src="assets/images/users/user-1.jpg" alt="user-img" title="Mat Helme" class="rounded-circle img-fluid">
                        <a href="javascript:void(0);" class="user-edit"><i class="mdi mdi-pencil"></i></a>
                    </div>
            
                    <h5><a href="javascript: void(0);">Geneva Kennedy</a> </h5>
                    <p class="text-muted mb-0"><small>Admin Head</small></p>
                </div>

                <!-- Settings -->
                <hr class="mt-0" />
                <h5 class="pl-3">Basic Settings</h5>
                <hr class="mb-0" />

                <div class="p-3">
                    <div class="checkbox checkbox-primary mb-2">
                        <input id="Rcheckbox1" type="checkbox" checked>
                        <label for="Rcheckbox1">
                            Notifications
                        </label>
                    </div>
                    <div class="checkbox checkbox-primary mb-2">
                        <input id="Rcheckbox2" type="checkbox" checked>
                        <label for="Rcheckbox2">
                            API Access
                        </label>
                    </div>
                    <div class="checkbox checkbox-primary mb-2">
                        <input id="Rcheckbox3" type="checkbox">
                        <label for="Rcheckbox3">
                            Auto Updates
                        </label>
                    </div>
                    <div class="checkbox checkbox-primary mb-2">
                        <input id="Rcheckbox4" type="checkbox" checked>
                        <label for="Rcheckbox4">
                            Online Status
                        </label>
                    </div>
                    <div class="checkbox checkbox-primary mb-0">
                        <input id="Rcheckbox5" type="checkbox" checked>
                        <label for="Rcheckbox5">
                            Auto Payout
                        </label>
                    </div>
                </div>

                <!-- Timeline -->
                <hr class="mt-0" />
                <h5 class="px-3">Messages <span class="float-right badge badge-pill badge-danger">25</span></h5>
                <hr class="mb-0" />
                <div class="p-3">
                    <div class="inbox-widget">
                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="assets/images/users/user-2.jpg" class="rounded-circle" alt=""></div>
                            <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Tomaslau</a></p>
                            <p class="inbox-item-text">I've finished it! See you so...</p>
                        </div>
                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="assets/images/users/user-3.jpg" class="rounded-circle" alt=""></div>
                            <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Stillnotdavid</a></p>
                            <p class="inbox-item-text">This theme is awesome!</p>
                        </div>
                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="assets/images/users/user-4.jpg" class="rounded-circle" alt=""></div>
                            <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Kurafire</a></p>
                            <p class="inbox-item-text">Nice to meet you</p>
                        </div>

                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="assets/images/users/user-5.jpg" class="rounded-circle" alt=""></div>
                            <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Shahedk</a></p>
                            <p class="inbox-item-text">Hey! there I'm available...</p>
                        </div>
                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="assets/images/users/user-6.jpg" class="rounded-circle" alt=""></div>
                            <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Adhamdannaway</a></p>
                            <p class="inbox-item-text">This theme is awesome!</p>
                        </div>
                    </div> <!-- end inbox-widget -->
                </div> <!-- end .p-3-->

            </div> <!-- end slimscroll-menu-->
        </div>
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- Plugins js-->
        <script src="assets/libs/flatpickr/flatpickr.min.js"></script>
        <script src="assets/libs/jquery-knob/jquery.knob.min.js"></script>
        <script src="assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>
        <script src="assets/libs/flot-charts/jquery.flot.js"></script>
        <script src="assets/libs/flot-charts/jquery.flot.time.js"></script>
        <script src="assets/libs/flot-charts/jquery.flot.tooltip.min.js"></script>
        <script src="assets/libs/flot-charts/jquery.flot.selection.js"></script>
        <script src="assets/libs/flot-charts/jquery.flot.crosshair.js"></script>

        <!-- Dashboar 1 init js-->
        <script src="assets/js/pages/dashboard-1.init.js"></script>

        <!-- App js-->
        <script src="assets/js/app.min.js"></script>
        
    </body>

</html>