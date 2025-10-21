<?php
session_start();
include('assets/inc/config.php');

if (isset($_POST['add_patient_checkup'])) {

    $check_number = $_POST['check_number'];
    $check_pat_number = $_POST['check_pat_number'];

    // Handle conditions
    $cons = isset($_POST['cons']) ? $_POST['cons'] : [];
    $other_cons = trim($_POST['other_cons']);
    if (!empty($other_cons)) {
        $cons[] = $other_cons;
    }
    $cons_str = implode(", ", $cons);

    // Handle symptoms
    $symptoms = isset($_POST['symptoms']) ? $_POST['symptoms'] : [];
    $other_symptom = trim($_POST['other_symptom']);
    if (!empty($other_symptom)) {
        $symptoms[] = $other_symptom;
    }
    $symptoms_str = implode(", ", $symptoms);

    $symptom_duration = $_POST['symptom_duration'];
    $diagnosed_allergies = $_POST['diagnosed_allergies'];
    $check_rd = $_POST['check_rd'];

    // Prepare and execute query
    $query = "INSERT INTO his_checkup 
        (check_number, check_pat_number, cons, symptoms, symptom_duration, diagnosed_allergies, check_rd) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('sssssss', $check_number, $check_pat_number, $cons_str, $symptoms_str, $symptom_duration, $diagnosed_allergies, $check_rd);

    if ($stmt->execute()) {
        $success = "Patient checkup successfully added";
    } else {
        $err = "Please try again later";
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
            <?php
                $pat_number = $_GET['pat_number'];
                $ret="SELECT  * FROM his_patients WHERE pat_number=?";
                $stmt= $mysqli->prepare($ret) ;
                $stmt->bind_param('s',$pat_number);
                $stmt->execute() ;//ok
                $res=$stmt->get_result();
                //$cnt=1;
                while($row=$res->fetch_object())
                {
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
                                                <li class="breadcrumb-item"><a href="his_doc_dashboard.php">Dashboard</a></li>
                                                <li class="breadcrumb-item"><a href="javascript: void(0);">Police Registration</a></li>
                                                <li class="breadcrumb-item active">Checkup</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">Checkup for <?php echo $row->pat_fname;?> <?php echo $row->pat_lname;?></h4>
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
                                                        <label for="inputEmail4" class="col-form-label">Patient Name</label>
                                                        <input type="text" required="required" readonly name="" value="<?php echo $row->pat_fname;?> <?php echo $row->pat_lname;?>" class="form-control" id="inputEmail4" placeholder="Patient's First Name">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="inputEmail4" class="col-form-label">Patient Number</label>
                                                        <input type="text" required="required" readonly name="check_pat_number" value="<?php echo $row->pat_number;?>" class="form-control" id="inputEmail4" placeholder="DD/MM/YYYY">
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                     <div class="form-group col-md-3">
                                                        <label for="inputPassword4" class="col-form-label">Patient Symptoms</label><br>
                                                        <label><input type="checkbox" name="symptoms[]" value="None"> None</label><br>
                                                        <label><input type="checkbox" name="symptoms[]" value="Fever"> Fever</label><br>
                                                        <label><input type="checkbox" name="symptoms[]" value="Cough"> Cough</label><br>
                                                        <label><input type="checkbox" name="symptoms[]" value="Headache"> Headache</label><br>
                                                        <label><input type="checkbox" name="symptoms[]" value="Fatigue"> Fatigue</label><br>
                                                        <label><input type="checkbox" name="symptoms[]" value="Shortness of Breath"> Shortness of Breath</label><br>
                                                        <label><input type="checkbox" name="symptoms[]" value="Nausea"> Nausea</label><br>
                                                        <label><input type="checkbox" name="symptoms[]" value="Sore Throat"> Sore Throat</label><br>
                                                        <label><input type="checkbox" name="symptoms[]" value="Loss of Taste or Smell"> Loss of Taste or Smell</label><br>
                                                        <label>Other:<input type="text" name="other_symptom"></label><br>
                                                    </div>

                                                    <div class="form-group col-md-3">
                                                    <label for="inputCity" class="col-form-label">Symptom Duration</label>
                                                    <input required="required" type="text" name="symptom_duration" class="form-control" id="inputCity">
                                                </div>

                                                    <div class="form-group col-md-3">
                                                        <label for="inputCity" class="col-form-label">Patient Condition:</label><br>
                                                        <label><input type="checkbox" name="cons[]" value="None"> None</label><br>
                                                        <label><input type="checkbox" name="cons[]" value="Asthma"> Asthma</label><br>
                                                        <label><input type="checkbox" name="cons[]" value="Hypertension"> Hypertension</label><br>
                                                        <label><input type="checkbox" name="cons[]" value="Diabetes"> Diabetes</label><br>
                                                        <label><input type="checkbox" name="cons[]" value="COPD"> COPD</label><br>
                                                        <label><input type="checkbox" name="cons[]" value="Heart Disease"> Heart Disease</label><br>
                                                        <label><input type="checkbox" name="cons[]" value="Stroke"> Stroke</label><br>
                                                        <label><input type="checkbox" name="cons[]" value="Arthritis"> Arthritis</label><br>
                                                        <label><input type="checkbox" name="cons[]" value="Chronic Kidney Disease"> Chronic Kidney Disease</label><br>
                                                        <label><input type="checkbox" name="cons[]" value="Depression"> Depression</label><br>
                                                        <label><input type="checkbox" name="cons[]" value="Anxiety"> Anxiety</label><br>
                                                        <label><input type="checkbox" name="cons[]" value="Chronic Pain"> Chronic Pain</label><br>
                                                        <label><input type="checkbox" name="cons[]" value="Cancer"> Cancer</label><br>
                                                        <label><input type="checkbox" name="cons[]" value="Obesity"> Obesity</label><br>
                                                        <label><input type="checkbox" name="cons[]" value="Osteoporosis"> Osteoporosis</label><br>
                                                        <label><input type="checkbox" name="cons[]" value="Alzheimer's Disease"> Alzheimer's Disease</label><br>
                                                        <label><input type="checkbox" name="cons[]" value="Parkinson's Disease"> Parkinson's Disease</label><br>
                                                        <label><input type="checkbox" name="cons[]" value="HIV/AIDS"> HIV/AIDS</label><br>
                                                        <label><input type="checkbox" name="cons[]" value="Sleep Apnea"> Sleep Apnea</label><br>
                                                        <label><input type="checkbox" name="cons[]" value="Migraine"> Migraine</label><br>
                                                        <label>Other:<input type="text" name="other_cons"></label><br>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="inputCity" class="col-form-label">Request Date</label>
                                                        <input required="required" type="date" name="check_rd" class="form-control" id="inputCity">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="inputAddress" class="col-form-label">Diagnosed Allergies</label>
                                                        <input required="required" type="text" class="form-control" name="diagnosed_allergies" id="inputAddress">
                                                    </div>
                                                </div>

                                                
                                                <hr>
                                                <div class="form-row">
                                                    
                                            
                                                    <div class="form-group col-md-2" style="display:none">
                                                        <?php 
                                                            $length = 5;    
                                                            $check_no =  substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,$length);
                                                        ?>
                                                        <label for="inputZip" class="col-form-label">Checkup Number</label>
                                                        <input type="hidden" name="check_number" value="<?php echo $check_no; ?>">
                                                    </div>
                                                </div>

                                                <button type="submit" name="add_patient_checkup" class="ladda-button btn btn-success" data-style="expand-right">Done</button>

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
            <?php }?>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

       
        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
        <script src="//cdn.ckeditor.com/4.6.2/basic/ckeditor.js"></script>
        <script type="text/javascript">
        CKEDITOR.replace('editor')
        </script>

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