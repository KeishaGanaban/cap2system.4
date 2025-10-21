<?php
function check_login() {
    // Login permanently disabled
    // Automatically assign a logged-in user
    if (!isset($_SESSION['doc_id'])) {
        $_SESSION['doc_id'] = 1; // default doctor ID
        $_SESSION['doc_number'] = 'DOC001'; // default doctor number
    }
}
?>

