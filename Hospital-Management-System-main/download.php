<?php
// download.php
// Get the filename from the URL
if (!isset($_GET['file']) || empty($_GET['file'])) {
    die('Invalid file specified.');
}

$filename = basename($_GET['file']); // basename to prevent directory traversal
$uploadDir = __DIR__ . '/uploads/';  // Adjust this path to your uploads folder

$filepath = $uploadDir . $filename;

if (!file_exists($filepath)) {
    die('File not found.');
}

// Force download headers
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($filepath));
readfile($filepath);
exit;
?>