<?php
require 'init.php';
require 'config.php';

if (!isset($_GET['type']) || !isset($_GET['file'])) {
    http_response_code(400);
    echo 'Bad request';
    exit;
}

$type = $_GET['type'];
$file = basename($_GET['file']); // prevent path traversal

if ($type === 'masuk') {
    $dir = UPLOAD_MASUK;
} elseif ($type === 'keluar') {
    $dir = UPLOAD_KELUAR;
} else {
    http_response_code(400);
    echo 'Tipe tidak valid';
    exit;
}

$path = $dir . $file;
if (!file_exists($path)) {
    http_response_code(404);
    echo 'File tidak ditemukan';
    exit;
}

$mime = mime_content_type($path) ?: 'application/octet-stream';
header('Content-Description: File Transfer');
header('Content-Type: ' . $mime);
header('Content-Disposition: attachment; filename="' . basename($path) . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($path));
readfile($path);
exit;
?>