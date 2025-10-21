<?php
session_start();
include('assets/inc/config.php');

if (isset($_POST['add_civillian'])) {
    $civ_fname     = $_POST['civ_fname'];
    $civ_lname     = $_POST['civ_lname'];    
    $civ_dob       = $_POST['civ_dob'];
    $civ_age       = $_POST['civ_age'];
    $civ_number    = $_POST['civ_number'];
    $civ_allergies = $_POST['civ_allergies'];
    $civ_phone     = $_POST['civ_phone'];
    $civ_type      = $_POST['civ_type'];
    $civ_location  = $_POST['civ_location'];

    // handle conditions
    $civ_conditions = isset($_POST['civ_conditions']) ? $_POST['civ_conditions'] : []; 
    $other_civ_conditions = trim($_POST['other_civ_conditions']);
    if (!empty($other_civ_conditions)) {
        $civ_conditions[] = $other_civ_conditions;
    }
    $civ_conditions_str = implode(", ", $civ_conditions);

    // handle symptoms
    $civ_symptoms = isset($_POST['civ_symptoms']) ? $_POST['civ_symptoms'] : []; 
    $other_civ_symptoms = trim($_POST['other_civ_symptoms']);
    if (!empty($other_civ_symptoms)) {
        $civ_symptoms[] = $other_civ_symptoms;
    }
    $civ_symptoms_str = implode(", ", $civ_symptoms);

    $query = "INSERT INTO his_civillians 
        (civ_fname, civ_lname, civ_dob, civ_age, civ_number, civ_allergies, civ_phone, civ_type, 
         civ_location, civ_conditions, civ_symptoms) 
        VALUES (?,?,?,?,?,?,?,?,?,?,?)";

    $stmt = $mysqli->prepare($query);
    $stmt->bind_param(
        'sssississss',
        $civ_fname, 
        $civ_lname, 
        $civ_dob, 
        $civ_age, 
        $civ_number, 
        $civ_allergies, 
        $civ_phone, 
        $civ_type, 
        $civ_location, 
        $civ_conditions_str, 
        $civ_symptoms_str
    );

    if ($stmt->execute()) {
        $success = "Civillian Details Added Successfully";
    } else {
        $err = "Please Try Again Or Try Later. Error: " . $stmt->error;
    }

    $stmt->close();
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
                                            <li class="breadcrumb-item active">Civilian Checkup</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Add Patient Details</h4>
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
                                                    <input type="text" required="required" name="civ_fname" class="form-control" id="inputEmail4" placeholder="Patient's First Name">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="inputPassword4" class="col-form-label">Last Name</label>
                                                    <input required="required" type="text" name="civ_lname" class="form-control"  id="inputPassword4" placeholder="Patient`s Last Name">
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="inputEmail4" class="col-form-label">Date Of Birth</label>
                                                    <input type="date" required="required" name="civ_dob" class="form-control" id="inputEmail4">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="inputPassword4" class="col-form-label">Age</label>
                                                    <input required="required" type="text" name="civ_age" class="form-control"  id="inputPassword4">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="inputCity" class="col-form-label">Mobile Number</label>
                                                    <input required="required" type="text" name="civ_phone" class="form-control" id="inputCity">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="inputState" class="col-form-label">Sex</label>
                                                    <select id="inputState" required="required" name="civ_type" class="form-control">
                                                        <option></option>
                                                        <option>Male</option>
                                                        <option>Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="inputCity" class="col-form-label">Location</label><br>
                                                    <select name="civ_location" class="form-control">
                                                        <option value="Abra"> Abra</option>
                                                        <option value="Apayao"> Apayao</option>
                                                        <option value="Benguet"> Benguet</option>
                                                        <option value="Ifugao"> Ifugao</option>
                                                        <option value="Kalinga"> Kalinga</option>
                                                        <option value="Mountain Province"> Mountain Province</option>
                                                        <option value="Baguio City"> Baguio City</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="inputCity" class="col-form-label">Patient Condition</label><br>
                                                    <label><input type="checkbox" name="civ_conditions[]" value="None"> None</label><br>
                                                    <label><input type="checkbox" name="civ_conditions[]" value="Asthma"> Asthma</label><br>
                                                    <label><input type="checkbox" name="civ_conditions[]" value="Hypertension"> Hypertension</label><br>
                                                    <label><input type="checkbox" name="civ_conditions[]" value="Diabetes"> Diabetes</label><br>
                                                    <label><input type="checkbox" name="civ_conditions[]" value="COPD"> COPD</label><br>
                                                    <label><input type="checkbox" name="civ_conditions[]" value="Heart Disease"> Heart Disease</label><br>
                                                    <label><input type="checkbox" name="civ_conditions[]" value="Stroke"> Stroke</label><br>
                                                    <label><input type="checkbox" name="civ_conditions[]" value="Arthritis"> Arthritis</label><br>
                                                    <label><input type="checkbox" name="civ_conditions[]" value="Chronic Kidney Disease"> Chronic Kidney Disease</label><br>
                                                    <label><input type="checkbox" name="civ_conditions[]" value="Depression"> Depression</label><br>
                                                    <label><input type="checkbox" name="civ_conditions[]" value="Anxiety"> Anxiety</label><br>
                                                    <label><input type="checkbox" name="civ_conditions[]" value="Chronic Pain"> Chronic Pain</label><br>
                                                    <label><input type="checkbox" name="civ_conditions[]" value="Cancer"> Cancer</label><br>
                                                    <label><input type="checkbox" name="civ_conditions[]" value="Obesity"> Obesity</label><br>
                                                    <label><input type="checkbox" name="civ_conditions[]" value="Osteoporosis"> Osteoporosis</label><br>
                                                    <label><input type="checkbox" name="civ_conditions[]" value="Alxheimer's Disease"> Alxheimer's Disease</label><br>
                                                    <label><input type="checkbox" name="civ_conditions[]" value="Parkinson's Disease"> Parkinson's Disease</label><br>
                                                    <label><input type="checkbox" name="civ_conditions[]" value="HIV/AIDS"> HIV/AIDS</label><br>
                                                    <label><input type="checkbox" name="civ_conditions[]" value="Sleep Apnea"> Sleep Apnea</label><br>
                                                    <label><input type="checkbox" name="civ_conditions[]" value="Migraine"> Migraine</label><br>
                                                    <label>Other:<input type="text" name="other_civ_conditions"></label><br>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="inputCity" class="col-form-label">Patient Symptoms: </label><br>
                                                    <label><input type="checkbox" name="civ_symptoms[]" value="Fever"> Fever</label><br>
                                                    <label><input type="checkbox" name="civ_symptoms[]" value="Cough"> Cough</label><br>
                                                    <label><input type="checkbox" name="civ_symptoms[]" value="Headache"> Headache</label><br>
                                                    <label><input type="checkbox" name="civ_symptoms[]" value="Fatigue"> Fatigue</label><br>
                                                    <label><input type="checkbox" name="civ_symptoms[]" value="Shortness of Breath"> Shortness of Breath</label><br>
                                                    <label><input type="checkbox" name="civ_symptoms[]" value="Nausea"> Nausea</label><br>
                                                    <label><input type="checkbox" name="civ_symptoms[]" value="Sore Throat"> Sore Throat</label><br>
                                                    <label><input type="checkbox" name="civ_symptoms[]" value="Loss of Taste or Smell"> Loss of Taste or Smell</label><br>
                                                    <label>Other:<input type="text" name="other_civ_symptoms"></label><br>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label for="inputCity" class="col-form-label">Diagnosed Allergies</label>
                                                    <input required="required" type="text" name="civ_allergies" class="form-control" id="inputCity">
                                                </div>
                                            </div>
                                                <div class="form-group col-md-2" style="display:none">
                                                    <?php 
                                                        $length = 5;    
                                                        $patient_number =  substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,$length);
                                                    ?>
                                                    <label for="inputZip" class="col-form-label">Patient Number</label>
                                                    <input type="text" name="civ_number" value="<?php echo $patient_number;?>" class="form-control" id="inputZip">
                                                </div>
                                            <div class="form-row">
                                                <button type="submit" name="add_civillian" class="ladda-button btn btn-primary" data-style="expand-right">Add Patient</button>
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