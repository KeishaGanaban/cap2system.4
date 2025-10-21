<?php
session_start();
include('assets/inc/config.php');

if (isset($_POST['add_patient'])) {
    $pat_fname    = $_POST['pat_fname'];
    $pat_lname    = $_POST['pat_lname'];    
    $pat_dob      = $_POST['pat_dob'];
    $pat_age      = $_POST['pat_age'];
    $pat_addr     = $_POST['pat_addr'];
    $pat_position = $_POST['pat_position'];
    $pat_phone    = $_POST['pat_phone'];
    $pat_type     = $_POST['pat_type'];
    $pat_location = $_POST['pat_location'];
    $pat_number   = $_POST['pat_number'];
    $pat_email    = $_POST['pat_email'];
    $pat_pwd      = password_hash($_POST['pat_pwd'], PASSWORD_BCRYPT);

    $query = "INSERT INTO his_patients 
        (pat_fname, pat_lname, pat_dob, pat_age, pat_addr, pat_position, pat_phone,
        pat_type, pat_location, pat_number, pat_email, pat_pwd) 
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";

    $stmt = $mysqli->prepare($query);

    if (!$stmt) {
        $err = "Database error: " . $mysqli->error;
    } else {
        $stmt->bind_param(
            'sssississsss',
            $pat_fname, 
            $pat_lname, 
            $pat_dob, 
            $pat_age,  
            $pat_addr, 
            $pat_position,
            $pat_phone, 
            $pat_type, 
            $pat_location, 
            $pat_number,
            $pat_email,
            $pat_pwd
        );

        if ($stmt->execute()) {
            $success = "Patient Details Added";
        } else {
            $err = "Please Try Again Or Try Later. Error: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>

<!--End Server Side-->
<!--End Patient Registration-->
<!DOCTYPE html>
<html lang="en">
    
    <!--Head-->
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
                                            <li class="breadcrumb-item"><a href="his_doc_dashboard.php">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Police Registration</a></li>
                                            <li class="breadcrumb-item active">Register Police</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Add Police Details</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 
                        <!-- Form row -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Fill all fields</h4>
                                        <!--Add Patient Form-->
                                        <form method="post">
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="inputEmail4" class="col-form-label">First Name</label>
                                                    <input type="text" required="required" name="pat_fname" class="form-control" id="inputEmail4" placeholder="Patient's First Name">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="inputPassword4" class="col-form-label">Last Name</label>
                                                    <input required="required" type="text" name="pat_lname" class="form-control"  id="inputPassword4" placeholder="Patient`s Last Name">
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="inputEmail4" class="col-form-label">Date Of Birth</label>
                                                    <input type="date" required="required" name="pat_dob" class="form-control" id="inputEmail4">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="inputPassword4" class="col-form-label">Age</label>
                                                    <input required="required" type="text" name="pat_age" class="form-control"  id="inputPassword4">
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="inputAddress" class="col-form-label">Address</label>
                                                    <input required="required" type="text" class="form-control" name="pat_addr" id="inputAddress">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="inputPosition" class="col-form-label">Position/Rank</label>
                                                    <select id="inputPosition" required="required" name="pat_position" class="form-control">
                                                        <option></option>
                                                        <option>Police General (PGEN)</option>
                                                        <option>Police Lieutenant General (PLTGEN)</option>
                                                        <option>Police Major General (PMGEN)</option>
                                                        <option>Police Brigadier General (PBGEN)</option>
                                                        <option>Police Colonel (PCOL)</option>
                                                        <option>Police Lieutenant Colonel (PLTCOL)</option>
                                                        <option>Police Major (PMAJ)</option>
                                                        <option>Police Captain (PCPT)</option>
                                                        <option>Police Lieutenant (PLT)</option>
                                                        <option>Police Executive Master Sergeant (PEMS)</option>
                                                        <option>Police Chief Master Sergeant (PCMS)</option>
                                                        <option>Police Senior Master Sergeant (PSMS)</option>
                                                        <option>Police Master Sergeant (PMSg)</option>
                                                        <option>Police Staff Sergeant (PSSg)</option>
                                                        <option>Police Corporal (PCpl)</option>
                                                        <option>Patrolman / Patrolwoman (Pat)</option>
                                                        <option>Cadet</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="inputCity" class="col-form-label">Mobile Number</label>
                                                    <input required="required" type="text" name="pat_phone" class="form-control" id="inputCity">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="inputState" class="col-form-label">Sex</label>
                                                    <select id="inputState" required="required" name="pat_type" class="form-control">
                                                        <option></option>
                                                        <option>Male</option>
                                                        <option>Female</option>
                                                    </select>
                                                </div>
                                            </div>    
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label for="inputCity" class="col-form-label">Location</label><br>
                                                    <select name="pat_location" class="form-control">
                                                        <option value="Abra"> Abra</option>
                                                        <option value="Apayao"> Apayao</option>
                                                        <option value="Benguet"> Benguet</option>
                                                        <option value="Ifugao"> Ifugao</option>
                                                        <option value="Kalinga"> Kalinga</option>
                                                        <option value="Mountain Province"> Mountain Province</option>
                                                        <option value="Baguio City"> Baguio City</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="inputAddress" class="col-form-label">Email</label>
                                                    <input required="required" type="email" class="form-control" name="pat_email" id="inputAddress">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="inputCity" class="col-form-label">Password</label>
                                                    <input required="required" type="password" name="pat_pwd" class="form-control" id="inputCity">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-2" style="display:none">
                                                    <?php 
                                                        $length = 5;    
                                                        $patient_number =  substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,$length);
                                                    ?>
                                                    <label for="inputZip" class="col-form-label">Patient Number</label>
                                                    <input type="hidden" name="pat_number" value="<?php echo $patient_number;?>" class="form-control" id="inputZip">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <button type="submit" name="add_patient" class="ladda-button btn btn-primary" data-style="expand-right">Add Patient</button>
                                            </div>
                                        </form>
                                        <!--End Patient Form-->
                                    </div> <!-- end card-body -->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                    </div> <!-- container -->

                </div> <!-- content -->

                <!-- Footer Start -->
                <?php include('assets/inc/footer.php');?>
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

       
        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- App js-->
        <script src="assets/js/app.min.js"></script>

        <!-- Loading buttons js -->
        <script src="assets/libs/ladda/spin.js"></script>
        <script src="assets/libs/ladda/ladda.js"></script>

        <!-- Buttons init js-->
        <script src="assets/js/pages/loading-btn.init.js"></script>
        
    </body>

</html>

