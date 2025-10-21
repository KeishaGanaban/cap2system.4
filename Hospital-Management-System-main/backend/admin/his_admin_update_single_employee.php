<?php
session_start();
include('assets/inc/config.php');

if (isset($_POST['update_doc'])) {
    // Get doc_number from URL (instead of doc_id)
    $doc_number = $_GET['doc_number'];

    // Get posted form data
    $doc_fname = $_POST['doc_fname'];
    $doc_lname = $_POST['doc_lname'];
    $doc_role = $_POST['doc_role'];
    $doc_email = $_POST['doc_email'];
    $doc_pwd = sha1(md5($_POST['doc_pwd']));
    $doc_dpic = $_FILES["doc_dpic"]["name"];

    // Handle file upload
    if (!empty($doc_dpic)) {
        move_uploaded_file($_FILES["doc_dpic"]["tmp_name"], "../doc/assets/images/users/" . $_FILES["doc_dpic"]["name"]);
    } else {
        // If no new image is uploaded, keep old one
        $query_old = "SELECT doc_dpic FROM his_docs WHERE doc_number = ?";
        $stmt_old = $mysqli->prepare($query_old);
        $stmt_old->bind_param('s', $doc_number);
        $stmt_old->execute();
        $stmt_old->bind_result($old_dpic);
        $stmt_old->fetch();
        $stmt_old->close();
        $doc_dpic = $old_dpic;
    }

    // Update query based on doc_number
    $query = "UPDATE his_docs 
              SET doc_fname = ?, doc_lname = ?, doc_role = ?, doc_email = ?, doc_pwd = ?, doc_dpic = ?
              WHERE doc_number = ?";
    $stmt = $mysqli->prepare($query);
    $rc = $stmt->bind_param('sssssss', $doc_fname, $doc_lname, $doc_role, $doc_email, $doc_pwd, $doc_dpic, $doc_number);
    $stmt->execute();

    if ($stmt) {
        $success = "Employee Details Updated Successfully";
    } else {
        $err = "Please Try Again Later";
    }
}
?>
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
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="his_admin_dashboard.php">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">Employee</a></li>
                                        <li class="breadcrumb-item active">Manage Employee</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Update Employee Details</h4>
                            </div>
                        </div>
                    </div>

                    <?php
                    $doc_number = $_GET['doc_number'];
                    $ret = "SELECT * FROM his_docs WHERE doc_number = ?";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->bind_param('s', $doc_number);
                    $stmt->execute();
                    $res = $stmt->get_result();

                    while ($row = $res->fetch_object()) {
                    ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Fill all fields</h4>
                                        <form method="post" enctype="multipart/form-data">
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label>First Name</label>
                                                    <input type="text" required name="doc_fname" value="<?php echo $row->doc_fname; ?>" class="form-control">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Last Name</label>
                                                    <input type="text" required name="doc_lname" value="<?php echo $row->doc_lname; ?>" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>Category</label>
                                                <select name="doc_role" required class="form-control">
                                                    <option selected><?php echo $row->doc_role; ?></option>
                                                    <option>Police Personnel</option>
                                                    <option>SHU</option>
                                                    <option>Regional Doctor</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" required name="doc_email" value="<?php echo $row->doc_email; ?>" class="form-control">
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label>Password</label>
                                                    <input type="password" required name="doc_pwd" class="form-control">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Profile Picture</label>
                                                    <input type="file" name="doc_dpic" class="form-control btn btn-success">
                                                    <?php if (!empty($row->doc_dpic)) { ?>
                                                        <small>Current: <img src="../doc/assets/images/users/<?php echo $row->doc_dpic; ?>" width="50"></small>
                                                    <?php } ?>
                                                </div>
                                            </div>

                                            <button type="submit" name="update_doc" class="btn btn-success ladda-button" data-style="expand-right">Update Employee</button>
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

    <div class="rightbar-overlay"></div>

    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>
    <script src="assets/libs/ladda/spin.js"></script>
    <script src="assets/libs/ladda/ladda.js"></script>
    <script src="assets/js/pages/loading-btn.init.js"></script>
</body>
</html>
