<?php
    $pat_id = $_SESSION['pat_id'];
    $pat_number = $_SESSION['pat_number'];
    $ret="SELECT * FROM  his_patients WHERE pat_id = ? AND pat_number = ?";
    $stmt= $mysqli->prepare($ret) ;
    $stmt->bind_param('is',$pat_id, $pat_number);
    $stmt->execute() ;//ok
    $res=$stmt->get_result();
    //$cnt=1;
    while($row=$res->fetch_object())
    {
?>
    <div class="navbar-custom">
        <ul class="list-unstyled topnav-menu float-right mb-0">
            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <img src="assets/images/users/<?php echo $row->pat_dpic;?>" alt="dpic" class="rounded-circle">
                    <span class="pro-user-name ml-1">
                        <?php echo $row->pat_fname;?> <?php echo $row->pat_lname;?> <i class="mdi mdi-chevron-down"></i> 
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                    <!-- item-->
                    <div class="dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Welcome !</h6>
                    </div>

                    <!-- item-->
                    <!-- <a href="his_pat_account.php" class="dropdown-item notify-item">
                        <i class="fas fa-user"></i>
                        <span>My Account</span>
                    </a> -->

                    <!--<a href="his_pat_update-account.php" class="dropdown-item notify-item">
                        <i class="fas fa-user-tag"></i>
                        <span>Update Account</span>
                    </a>-->


                    <div class="dropdown-divider"></div>

                    <!-- item-->
                    <a href="his_pat_logout_partial.php" class="dropdown-item notify-item">
                        <i class="fe-log-out"></i>
                        <span>Logout</span>
                    </a>

                </div>
            </li>

           

        </ul>

        <!-- LOGO -->
        <div class="logo-box">
            <a href="his_admin_dashboard.php" class="logo text-center">
                <span class="logo-lg">
                    <img src="assets/images/pnp.png" alt="" height="64">
                    <!-- <span class="logo-lg-text-light">UBold</span> -->
                </span>
                <span class="logo-sm">
                    <!-- <span class="logo-sm-text-dark">U</span> -->
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
<?php }?>