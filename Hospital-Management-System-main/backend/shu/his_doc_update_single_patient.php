<!-- Server side code to handle Patient Update -->
<?php
session_start();
include('assets/inc/config.php');

if (isset($_POST['update_patient'])) {
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

    // SQL to update captured values
    $query = "UPDATE his_patients 
              SET pat_fname=?, pat_lname=?, pat_dob=?, pat_age=?, pat_addr=?, pat_position=?, pat_phone=?, pat_type=?, pat_location=? 
              WHERE pat_number=?";

    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('sssississs', 
        $pat_fname, 
        $pat_lname, 
        $pat_dob, 
        $pat_age, 
        $pat_addr, 
        $pat_position, 
        $pat_phone, 
        $pat_type, 
        $pat_location, 
        $pat_number
    );

    if ($stmt->execute()) {
        $success = "Patient details updated successfully.";
    } else {
        $err = "Error updating patient details. Please try again.";
    }
}
?>
<!-- End Server Side -->
<!DOCTYPE html>
<html lang="en">
<?php include('assets/inc/head.php'); ?>
<body>

    <div id="wrapper">
        <?php include("assets/inc/nav.php"); ?>
        <?php include("assets/inc/sidebar.php"); ?>

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">

                    <!-- Page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="his_admin_dashboard.php">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">Police Registration</a></li>
                                        <li class="breadcrumb-item active">Manage Police</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Update Police Details</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Load current patient details -->
                    <?php
                    $pat_number = $_GET['pat_number'];
                    $ret = "SELECT * FROM his_patients WHERE pat_number=?";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->bind_param('s', $pat_number);
                    $stmt->execute();
                    $res = $stmt->get_result();

                    while ($row = $res->fetch_object()) {
                    ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Edit details below</h4>
                                    <form method="post">
                                        <input type="hidden" name="pat_number" value="<?php echo $row->pat_number; ?>">

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>First Name</label>
                                                <input type="text" required name="pat_fname" value="<?php echo $row->pat_fname; ?>" class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Last Name</label>
                                                <input type="text" required name="pat_lname" value="<?php echo $row->pat_lname; ?>" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Date of Birth</label>
                                                <input type="date" required name="pat_dob" value="<?php echo $row->pat_dob; ?>" class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Age</label>
                                                <input type="number" required name="pat_age" value="<?php echo $row->pat_age; ?>" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="form-group col-md-12">
                                                <label>Address</label>
                                                <input type="text" required name="pat_addr" value="<?php echo $row->pat_addr; ?>" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Mobile Number</label>
                                                <input type="text" required name="pat_phone" value="<?php echo $row->pat_phone; ?>" class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Sex</label>
                                                <select name="pat_type" required class="form-control">
                                                    <option value="">Choose</option>
                                                    <option value="Male" <?php if($row->pat_type=='Male') echo 'selected'; ?>>Male</option>
                                                    <option value="Female" <?php if($row->pat_type=='Female') echo 'selected'; ?>>Female</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Location</label>
                                                <select name="pat_location" class="form-control">
                                                    <?php
                                                    $locations = [
                                                        "Abra", "Apayao", "Benguet", "Ifugao", 
                                                        "Kalinga", "Mountain Province", "Baguio City"
                                                    ];
                                                    foreach ($locations as $loc) {
                                                        $selected = ($row->pat_location == $loc) ? "selected" : "";
                                                        echo "<option value='$loc' $selected>$loc</option>";
                                                    }
                                                    ?>
                                                </select>
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
                                        <button type="submit" name="update_patient" class="btn btn-success">
                                            Update Patient
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>

            <?php include('assets/inc/footer.php'); ?>
        </div>
    </div>

    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>
</body>
</html>
