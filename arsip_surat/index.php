<?php
require 'init.php';
require 'config.php';
ensure_login();
include 'header.php';
include 'sidebar.php';

// === Ambil bulan & tahun dari request / default saat ini ===
$bulan = isset($_GET['bulan']) ? (int)$_GET['bulan'] : date('n');
$tahun = isset($_GET['tahun']) ? (int)$_GET['tahun'] : date('Y');

// === Total Surat Masuk & Keluar (semua data) ===
$totalMasuk  = $koneksi->query("SELECT COUNT(*) as jml FROM surat_masuk")->fetch_assoc()['jml'] ?? 0;
$totalKeluar = $koneksi->query("SELECT COUNT(*) as jml FROM surat_keluar")->fetch_assoc()['jml'] ?? 0;

// === Statistik per bulan (filter berdasarkan tgl_surat) ===
$statMasuk  = $koneksi->query("SELECT COUNT(*) as jml FROM surat_masuk WHERE MONTH(tgl_surat)=$bulan AND YEAR(tgl_surat)=$tahun")->fetch_assoc()['jml'] ?? 0;
$statKeluar = $koneksi->query("SELECT COUNT(*) as jml FROM surat_keluar WHERE MONTH(tgl_surat)=$bulan AND YEAR(tgl_surat)=$tahun")->fetch_assoc()['jml'] ?? 0;

// === Data grafik (12 bulan, 1 tahun) ===
$labels = [];
$dataMasuk = [];
$dataKeluar = [];
for ($m = 1; $m <= 12; $m++) {
    $labels[] = date('M', mktime(0,0,0,$m,1));
    $q1 = $koneksi->query("SELECT COUNT(*) as jml FROM surat_masuk WHERE MONTH(tgl_surat)=$m AND YEAR(tgl_surat)=$tahun")->fetch_assoc();
    $q2 = $koneksi->query("SELECT COUNT(*) as jml FROM surat_keluar WHERE MONTH(tgl_surat)=$m AND YEAR(tgl_surat)=$tahun")->fetch_assoc();
    $dataMasuk[]  = $q1['jml'] ?? 0;
    $dataKeluar[] = $q2['jml'] ?? 0;
}
?>

<div class="container-fluid">
    <h2 style="color: black;">Selamat Datang, <?= $_SESSION['user']; ?> 👋</h2>
  <p style="color: black;">Ini halaman dashboard Arsip Surat.</p>

  <!-- Kartu Total -->
  <div class="row mb-4">
    <div class="col-md-4">
      <div class="card shadow-sm p-3 text-center">
        <h6><i class="fa fa-inbox me-2"></i> Surat Masuk</h6>
        <h3><?php echo $totalMasuk; ?></h3>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm p-3 text-center">
        <h6><i class="fa fa-paper-plane me-2"></i> Surat Keluar</h6>
        <h3><?php echo $totalKeluar; ?></h3>
      </div>
    </div>
  </div>



  <!-- Grafik -->
  <div class="card shadow-sm p-3 mb-4">
    <canvas id="chartSurat" height="100"></canvas>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('chartSurat');
new Chart(ctx, {
  type: 'line',
  data: {
    labels: <?php echo json_encode($labels); ?>,
    datasets: [
      { label: 'Surat Masuk', data: <?php echo json_encode($dataMasuk); ?>, borderColor: '#0d47a1', backgroundColor:'#0d47a1', fill:false },
      { label: 'Surat Keluar', data: <?php echo json_encode($dataKeluar); ?>, borderColor: '#42a5f5', backgroundColor:'#42a5f5', fill:false }
    ]
  },
  options: { responsive:true, maintainAspectRatio:false }
});
</script>

<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>

</body>
</html>

<?php include 'footer.php'; ?>
<?php include 'style.php'; ?>
