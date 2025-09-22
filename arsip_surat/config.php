<?php
// Database config - update if needed
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'arsip_surat';

// Upload directories (filesystem) and URL paths (relative to project root)
// Direktori Upload
if (!defined('UPLOAD_DIR')) define('UPLOAD_DIR', __DIR__ . '/upload/');
if (!defined('UPLOAD_MASUK')) define('UPLOAD_MASUK', UPLOAD_DIR . 'surat_masuk/');
if (!defined('UPLOAD_KELUAR')) define('UPLOAD_KELUAR', UPLOAD_DIR . 'surat_keluar/');

// URL untuk akses file
if (!defined('BASE_URL')) define('BASE_URL', 'http://localhost/arsip_surat/');
if (!defined('UPLOAD_MASUK_URL')) define('UPLOAD_MASUK_URL', BASE_URL . 'upload/surat_masuk/');
if (!defined('UPLOAD_KELUAR_URL')) define('UPLOAD_KELUAR_URL', BASE_URL . 'upload/surat_keluar/');


// Create mysqli connection
$koneksi = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>