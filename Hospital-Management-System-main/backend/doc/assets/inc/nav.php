<?php
if (!isset($_SESSION['doc_id'], $_SESSION['doc_number'])) {
    header("Location: his_doc_logout_partial.php");
    exit();
}

$doc_id = $_SESSION['doc_id'];
$doc_number = $_SESSION['doc_number'];

$ret = "SELECT * FROM his_docs WHERE doc_id = ? AND doc_number = ?";
$stmt = $mysqli->prepare($ret);
$stmt->bind_param('is', $doc_id, $doc_number);
$stmt->execute();
$res = $stmt->get_result();

if ($row = $res->fetch_object()) {
?>
    <div class="navbar-custom">
        <ul class="list-unstyled topnav-menu float-right mb-0">
            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <img src="assets/images/users/<?php echo htmlspecialchars($row->doc_dpic); ?>" alt="dpic" class="rounded-circle">
                    <span class="pro-user-name ml-1">
                        <?php echo htmlspecialchars($row->doc_fname . ' ' . $row->doc_lname); ?> <i class="mdi mdi-chevron-down"></i>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown">
                    <div class="dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Welcome!</h6>
                    </div>

                    <a href="his_doc_update-account.php" class="dropdown-item notify-item">
                        <i class="fas fa-user-tag"></i>
                        <span>Update Account</span>
                    </a>

                    <div class="dropdown-divider"></div>

                    <a href="his_doc_logout_partial.php" class="dropdown-item notify-item">
                        <i class="fe-log-out"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </li>
        </ul>

        <!-- LOGO -->
        <div class="logo-box">
            <a href="his_doc_dashboard.php" class="logo text-center">
                <span class="logo-lg">
                    <img src="assets/images/pnp.png" alt="" height="64">
                </span>
                <span class="logo-sm">
                    <img src="assets/images/pnp.png" alt="" height="44">
                </span>
            </a>
        </div>

        <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
            <li>
                <button class="button-menu-mobile waves-effect waves-light">
                    <i class="fe-menu"></i>
                </button>
            </li>
        </ul>
    </div>
<?php
} else {
    echo "<p style='color:red;text-align:center;'>Doctor not found.</p>";
}
$stmt->close();
?>
