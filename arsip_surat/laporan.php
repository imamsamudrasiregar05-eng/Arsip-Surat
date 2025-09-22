<?php
require 'init.php';
require 'config.php';
ensure_login();
include 'header.php';
include 'sidebar.php';

// ambil filter tanggal
$from = $_GET['from'] ?? '';
$to   = $_GET['to'] ?? '';

$where = "";
if ($from && $to) {
    $where = "WHERE tgl_surat BETWEEN '".$from."' AND '".$to."'";
}
?>

<h3 class="mb-4">Laporan Surat</h3>

<!-- Filter tanggal -->
<form method="get" class="row g-3 mb-3">
  <div class="col-md-3">
    <label>Dari Tanggal</label>
    <input type="date" name="from" class="form-control" value="<?php echo $from; ?>">
  </div>
  <div class="col-md-3">
    <label>Sampai Tanggal</label>
    <input type="date" name="to" class="form-control" value="<?php echo $to; ?>">
  </div>
  <div class="col-md-3 d-flex align-items-end">
    <button type="submit" class="btn btn-primary me-2">Filter</button>
    <a href="laporan.php" class="btn btn-secondary">Reset</a>
  </div>
</form>

<!-- Tabs -->
<ul class="nav nav-tabs" id="laporanTab" role="tablist">
  <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#masuk">Surat Masuk</a></li>
  <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#keluar">Surat Keluar</a></li>
</ul>

<div class="tab-content mt-3">
  <!-- Surat Masuk -->
  <div class="tab-pane fade show active" id="masuk">
    <div class="d-flex justify-content-between mb-2">
      <h5>Data Surat Masuk</h5>
      <button class="btn btn-danger btn-sm" onclick="exportPDF('tableMasuk','Laporan Surat Masuk')">Export PDF</button>
    </div>
    <div class="card shadow-sm p-2">
      <div class="table-responsive">
        <table class="table table-striped" id="tableMasuk">
          <thead class="table-primary">
            <tr>
              <th>No</th>
              <th>No Surat</th>
              <th>Tanggal Surat</th>
              <th>Jenis Surat</th>
              <th>Karyawan</th>
              <th>File</th>
              <th>Created At</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            $sql = "SELECT * FROM surat_masuk $where ORDER BY id DESC";
            $res = $koneksi->query($sql);
            while($r = $res->fetch_assoc()){
                echo "<tr>
                        <td>".$no++."</td>
                        <td>".$r['no_surat']."</td>
                        <td>".$r['tgl_surat']."</td>
                        <td>".$r['jenis_surat']."</td>
                        <td>".$r['karyawan']."</td>
                        <td>".($r['file_surat'] ? "<a href='".UPLOAD_MASUK_URL.$r['file_surat']."' target='_blank'>".$r['file_surat']."</a>" : "-")."</td>
                        <td>".$r['created_at']."</td>
                      </tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Surat Keluar -->
  <div class="tab-pane fade" id="keluar">
    <div class="d-flex justify-content-between mb-2">
      <h5>Data Surat Keluar</h5>
      <button class="btn btn-danger btn-sm" onclick="exportPDF('tableKeluar','Laporan Surat Keluar')">Export PDF</button>
    </div>
    <div class="card shadow-sm p-2">
      <div class="table-responsive">
        <table class="table table-striped" id="tableKeluar">
          <thead class="table-primary">
            <tr>
              <th>No</th>
              <th>No Surat</th>
              <th>Tanggal Surat</th>
              <th>Jenis Surat</th>
              <th>File</th>
              <th>Created At</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            $sql = "SELECT * FROM surat_keluar $where ORDER BY id DESC";
            $res = $koneksi->query($sql);
            while($r = $res->fetch_assoc()){
                echo "<tr>
                        <td>".$no++."</td>
                        <td>".$r['no_surat']."</td>
                        <td>".$r['tgl_surat']."</td>
                        <td>".$r['jenis_surat']."</td>
                        <td>".($r['file_surat'] ? "<a href='".UPLOAD_KELUAR_URL.$r['file_surat']."' target='_blank'>".$r['file_surat']."</a>" : "-")."</td>
                        <td>".$r['created_at']."</td>
                      </tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
// Export PDF
function exportPDF(tableID, title){
    var table = document.getElementById(tableID).outerHTML;
    var win = window.open('', '', 'height=700,width=900');
    win.document.write('<html><head>');
    win.document.write('<title>'+title+'</title>');
    win.document.write('<style>body{font-family:Arial} table{border-collapse:collapse;width:100%} table,th,td{border:1px solid #333;padding:6px;text-align:left} th{background:#0d47a1;color:#fff}</style>');
    win.document.write('</head><body>');
    win.document.write('<h3 style="text-align:center">'+title+'</h3>');
    win.document.write(table);
    win.document.write('</body></html>');
    win.document.close();
    win.print();
}
</script>

<?php include 'footer.php'; ?>
<?php include 'style.php'; ?>
