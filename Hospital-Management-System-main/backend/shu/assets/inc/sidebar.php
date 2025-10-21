<div class="left-side-menu">

    <div class="slimscroll-menu" style="position: relative; z-index:2;">

        <!--- Sidemenu -->
        <div id="sidebar-menu" style="font-family: 'Roboto', sans-serif;">

            <ul class="metismenu" id="side-menu" style="list-style: none; padding: 0; margin: 0;">

                <li class="menu-title" style="padding: 15px 20px; font-weight: 700; color: #ffca28; text-transform: uppercase;">Navigation</li>

                <li>
                    <a href="his_doc_dashboard.php" style="display:flex; align-items:center; padding: 12px 20px; border-radius: 10px; color:#ffffff; transition: all 0.3s;">
                        <i class="fe-airplay" style="margin-right:10px; font-size: 18px; color:#ffca28;"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                <li>
                   <a href="javascript: void(0);" style="display:flex; align-items:center; padding: 12px 20px; border-radius: 10px; color:#ffffff;">
                        <i class="fab fa-accessible-icon" style="margin-right:10px; font-size: 18px; color:#ffca28;"></i>
                        <span> Police Registration</span>
                        <span class="menu-arrow" style="margin-left:auto; font-size:14px;">&#9662;</span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false" style="list-style:none; padding-left: 20px; display:none;">
                        <li>
                            <a href="his_doc_register_patient.php" style="padding:8px 15px; border-radius:8px; display:block; color:#ffffff;">Register Police</a>
                        </li>
                        <li>
                            <a href="his_doc_manage_patient.php" style="padding:8px 15px; border-radius:8px; display:block; color:#ffffff;">Manage Police</a>
                        </li>
                        <hr>
                        <li>
                            <a href="his_doc_register_civillian.php" style="padding:8px 15px; border-radius:8px; display:block; color:#ffffff;">Civilian Checkup</a>
                        </li>
                        <li>
                            <a href="his_doc_manage_civillian.php" style="padding:8px 15px; border-radius:8px; display:block; color:#ffffff;">Manage Civilian</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" style="display:flex; align-items:center; padding: 12px 20px; border-radius: 10px; color:#ffffff; transition: all 0.3s;">
                        <i class="mdi mdi-flask" style="margin-right:10px; font-size: 18px; color:#ffca28;"></i>
                        <span> Laboratory </span>
                        <span class="menu-arrow" style="margin-left:auto; font-size:14px;">&#9662;</span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false" style="list-style:none; padding-left: 20px; display:none;">
                        <li>
                            <a href="his_doc_patient_lab_test.php" style="padding:8px 15px; border-radius:8px; display:block; color:#ffffff; transition: all 0.3s;">Patient Lab Tests</a>
                        </li>
                        <li>
                            <a href="his_doc_patient_lab_vitals.php" style="padding:8px 15px; border-radius:8px; display:block; color:#ffffff; transition: all 0.3s;">Patient Vitals</a>
                        </li>
                    </ul>
                </li>

            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>

<!-- Optional CSS to make sidebar match modern design -->
<style>
.left-side-menu {
    background-color: #0d47a1; /* deep blue matching login bg */
    height: 100vh;
}

#sidebar-menu a:hover {
    background-color: rgba(255, 202, 40, 0.2);
    color: #ffca28 !important;
    text-decoration: none;
}

.nav-second-level a:hover {
    background-color: rgba(255, 202, 40, 0.15);
    color: #ffca28 !important;
}

.menu-arrow {
    transition: transform 0.3s;
}

.metismenu > li > a[aria-expanded="true"] .menu-arrow {
    transform: rotate(180deg);
}
</style>

<!-- Optional JS to toggle submenus -->
<!-- Fixed JS: independent toggle for each dropdown -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Select only the menu items that have a submenu
    const dropdownToggles = document.querySelectorAll('#side-menu > li > a[href="javascript: void(0);"]');

    dropdownToggles.forEach(function(toggle) {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();

            const submenu = this.nextElementSibling;

            // Close all other open submenus
            document.querySelectorAll('#side-menu .nav-second-level').forEach(function(otherSubmenu) {
                if (otherSubmenu !== submenu) {
                    otherSubmenu.style.display = 'none';
                }
            });

            // Toggle this one
            if (submenu && submenu.classList.contains('nav-second-level')) {
                submenu.style.display = (submenu.style.display === 'block') ? 'none' : 'block';
            }
        });
    });
});
</script>

