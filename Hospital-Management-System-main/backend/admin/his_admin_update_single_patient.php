<?php
session_start();
include('assets/inc/config.php');

if (isset($_POST['update_patient'])) {
    $pat_email  = $_POST['pat_email'];
    $pat_pwd    = password_hash($_POST['pat_pwd'], PASSWORD_BCRYPT);
    $pat_number = $_POST['pat_number'];

    $query = "UPDATE his_patients SET pat_email=?, pat_pwd=? WHERE pat_number=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('sss', $pat_email, $pat_pwd, $pat_number);

    if ($stmt->execute()) {
        $success = "Patient details updated successfully.";
    } else {
        $err = "Error updating patient details. Please try again.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include('assets/inc/head.php'); ?>
<body>
    <div id="wrapper">
        <?php include("assets/inc/nav.php"); ?>
        <?php include("assets/inc/sidebar.php"); ?>

        <?php if(isset($success)) { ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $success; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php } ?>
        <?php if(isset($err)) { ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $err; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php } ?>

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">

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
                                                <label>Patient Name</label>
                                                <input type="text" readonly name="pat_fullname"
                                                       value="<?php echo $row->pat_fname . ' ' . $row->pat_lname; ?>"
                                                       class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Rank</label>
                                                <input type="text" readonly name="pat_position"
                                                       value="<?php echo $row->pat_position; ?>"
                                                       class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Email</label>
                                                <input type="email" required name="pat_email"
                                                       value="<?php echo $row->pat_email; ?>"
                                                       class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Password</label>
                                                <input type="password" required name="pat_pwd"
                                                       class="form-control" placeholder="Enter new password">
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
