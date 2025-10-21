<!-- Server side code to handle Patient Update -->
<?php
session_start();
include('assets/inc/config.php');

if (isset($_POST['update_civilian'])) {
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

    // SQL to update captured values
    $query = "UPDATE his_patients 
              SET civ_fname=?, civ_lname=?, civ_dob=?, civ_age=?, civ_allergies=?, civ_phone=?, civ_type=?, civ_location=?, civ_conditions=?, civ_symptoms=? 
              WHERE civ_number=?";

    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('sssississss',
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
                                        <li class="breadcrumb-item active">Manage Civilian</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Update Patient Details</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Load current patient details -->
                    <?php
                    $civ_number = $_GET['civ_number'];
                    $ret = "SELECT * FROM his_civillians WHERE civ_number=?";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->bind_param('s', $civ_number);
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
                                        <input type="hidden" name="civ_number" value="<?php echo $row->civ_number; ?>">

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>First Name</label>
                                                <input type="text" required name="civ_fname" value="<?php echo $row->civ_fname; ?>" class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Last Name</label>
                                                <input type="text" required name="civ_lname" value="<?php echo $row->civ_lname; ?>" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Date of Birth</label>
                                                <input type="date" required name="civ_dob" value="<?php echo $row->civ_dob; ?>" class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Age</label>
                                                <input type="number" required name="civ_age" value="<?php echo $row->civ_age; ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Mobile Number</label>
                                                <input type="text" required name="civ_phone" value="<?php echo $row->civ_phone; ?>" class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Sex</label>
                                                <select name="civ_type" required class="form-control">
                                                    <option value="">Choose</option>
                                                    <option value="Male" <?php if($row->pat_type=='Male') echo 'selected'; ?>>Male</option>
                                                    <option value="Female" <?php if($row->pat_type=='Female') echo 'selected'; ?>>Female</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                            <label>Location</label>
                                            <select name="civ_location" class="form-control">
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

                                        <button type="submit" name="update_civilian" class="btn btn-success">
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
