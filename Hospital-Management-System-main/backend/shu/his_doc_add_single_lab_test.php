<?php
	session_start();
	include('assets/inc/config.php');
		if(isset($_POST['add_patient_lab_test']))
		{
			$lab_pat_name = $_POST['lab_pat_name'];
            $lab_pat_number  = $_POST['lab_pat_number'];

            if (isset($_FILES['lab_pat_tests']) && $_FILES['lab_pat_tests']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['lab_pat_tests']['tmp_name'];
                $fileName = $_FILES['lab_pat_tests']['name'];
                $fileSize = $_FILES['lab_pat_tests']['size'];
                $fileType = $_FILES['lab_pat_tests']['type'];
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                $allowedExtensions = ['pdf', 'jpg', 'png', 'docx'];
                $allowedMimeTypes = ['application/pdf', 'image/jpeg', 'image/png', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];

                if (!in_array($fileExtension, $allowedExtensions) || !in_array($fileType, $allowedMimeTypes)) {
                    die("❌ Invalid file type.");
                }

                $uploadDir = realpath(__DIR__ . '/../../uploads') . DIRECTORY_SEPARATOR;
                $newFileName = uniqid('file_', true) . '.' . $fileExtension;
                $destPath = $uploadDir . $newFileName;

                if (move_uploaded_file($fileTmpPath, $destPath)) {
                    echo "✅ File uploaded successfully.";
                } else {
                    echo "❌ Error moving the file.";
                }
            } else {
                echo "❌ No file uploaded or upload error.";
            }

            $lab_number  = $_POST['lab_number'];
            //$pres_number = $_POST['pres_number'];
            //$pres_ins = $_POST['pres_ins'];
            //$pres_pat_ailment = $_POST['pres_pat_ailment'];
            //sql to insert captured values
			$query="INSERT INTO  his_laboratory  (lab_pat_number, lab_pat_tests, lab_number ) VALUES(?,?,?)";
			$stmt = $mysqli->prepare($query);
			$rc=$stmt->bind_param('sss', $lab_pat_number, $newFileName, $lab_number);
			if ($stmt->execute()) {
                $success = "Patient Laboratory Tests Added";
            } else {
                $err = "Please Try Again Or Try Later";
                error_log("DB Error: " . $stmt->error); // helpful for debugging
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
                $ret = "
                    SELECT p.*, c.symptoms
                    FROM his_patients p
                    LEFT JOIN his_checkup c ON p.pat_number = c.check_pat_number
                    ORDER BY RAND()
                    LIMIT 100
                ";
                $stmt = $mysqli->prepare($ret);
                $stmt->execute();
                $res = $stmt->get_result();

                $cnt=1;
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
                                                <li class="breadcrumb-item"><a href="his_admin_dashboard.php">Dashboard</a></li>
                                                <li class="breadcrumb-item"><a href="javascript: void(0);">Laboratory</a></li>
                                                <li class="breadcrumb-item active">Add Lab Test</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">Add Lab Test</h4>
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
                                            <form method="post" enctype="multipart/form-data">
                                                <div class="form-row">

                                                    <div class="form-group col-md-6">
                                                        <label for="inputEmail4" class="col-form-label">Patient Name</label>
                                                        <input type="text" required="required" readonly name="lab_pat_name" value="<?php echo $row->pat_fname;?> <?php echo $row->pat_lname;?>" class="form-control" id="inputEmail4" placeholder="Patient's First Name">
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label for="inputPassword4" class="col-form-label">Patient Symptoms</label>
                                                        <input required="required" type="text" readonly name="lab_pat_condition" value="<?php echo htmlspecialchars($row->symptoms); ?>" class="form-control"  id="inputPassword4" placeholder="Patient`s Last Name">
                                                    </div>

                                                </div>

                                                <div class="form-row">

                                                    <div class="form-group col-md-12">
                                                        <label for="inputEmail4" class="col-form-label">Patient Number</label>
                                                        <input type="text" required="required" readonly name="lab_pat_number" value="<?php echo $row->pat_number;?>" class="form-control" id="inputEmail4" placeholder="DD/MM/YYYY">
                                                    </div>


                                                </div>

                                                
                                                <hr>
                                                <div class="form-row">
                                                    
                                            
                                                    <div class="form-group col-md-2" style="display:none">
                                                        <?php 
                                                            $length = 5;    
                                                            $pres_no =  substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,$length);
                                                        ?>
                                                        <label for="inputZip" class="col-form-label">Lab Test Number</label>
                                                        <p class="form-control" id="inputZip"></p>
                                                        <input type="text" name="lab_number" value="<?php echo $pres_no;?>" class="form-control" id="inputZip">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                        <label for="inputAddress" class="col-form-label">Laboratory Tests</label>
                                                        <input type="file" required="required" class="form-control" name="lab_pat_tests">
                                                </div>

                                                <button type="submit" name="add_patient_lab_test" class="ladda-button btn btn-success" data-style="expand-right" value="Upload">Add Laboratory Test</button>

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