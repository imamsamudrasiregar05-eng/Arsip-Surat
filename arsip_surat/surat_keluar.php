<?php
require 'init.php';
require 'config.php';
ensure_login();
include 'header.php';
include 'sidebar.php';

// === Proses Tambah Surat Keluar ===
if (isset($_POST['addKeluar'])) {
    $no       = $koneksi->real_escape_string($_POST['no_surat']);
    $judul    = $koneksi->real_escape_string($_POST['judul_surat']);
    $tgl      = $koneksi->real_escape_string($_POST['tgl_surat']);
    $jenis_surat  = $koneksi->real_escape_string($_POST['jenis_surat']);
    $tujuan   = $koneksi->real_escape_string($_POST['tujuan']);
    $karyawan = $koneksi->real_escape_string($_POST['karyawan']);

    $fileName = null;
    if (!empty($_FILES['file_surat']['name'])) {
        $f   = $_FILES['file_surat'];
        $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
        $allowed = ['pdf'];
        if (in_array($ext, $allowed) && $f['size'] <= 2*1024*1024) {
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', basename($f['name']));
            if (!is_dir(UPLOAD_KELUAR)) mkdir(UPLOAD_KELUAR, 0755, true);
            if (!move_uploaded_file($f['tmp_name'], UPLOAD_KELUAR . $fileName)) {
                $error = 'Gagal menyimpan file upload';
                $fileName = null;
            }
        } else {
            $error = 'Hanya PDF (max 2MB) yang diizinkan';
        }
    }

    $koneksi->query("INSERT INTO surat_keluar 
    (no_surat, judul_surat, tgl_surat, jenis_surat, tujuan, karyawan , file_surat) VALUES 
    ('$no','$judul','$tgl','$jenis_surat','$tujuan','$karyawan','$fileName')");

    header('Location: surat_keluar.php');
    exit;
}

// === Proses Hapus ===
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $row = $koneksi->query("SELECT file_surat FROM surat_keluar WHERE id=$id")->fetch_assoc();
    if ($row && $row['file_surat']) {
        @unlink(UPLOAD_KELUAR . $row['file_surat']);
    }
    $koneksi->query("DELETE FROM surat_keluar WHERE id=$id");
    header('Location: surat_keluar.php');
    exit;
}

// === Ambil Data ===
$data = $koneksi->query("SELECT * FROM surat_keluar ORDER BY created_at DESC");
?>

<h3>Surat Keluar</h3>
<div class="mb-3">
  <button class="btn" style="background:#0d47a1;color:#fff" data-bs-toggle="modal" data-bs-target="#modalAdd">
    Tambah Surat Keluar
  </button>
</div>

<?php if(isset($error)): ?>
  <div class="alert alert-warning"><?php echo $error; ?></div>
<?php endif; ?>

<div class="card p-3">
  <table id="tblKeluar" class="table table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>No Surat</th>
        <th>Judul Surat</th>
        <th>Tgl Surat</th>
        <th>Jenis Surat</th>
        <th>Tujuan</th>
        <th>Karyawan</th>
        <th>File</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php $i=1; while($row = $data->fetch_assoc()): ?>
      <tr>
        <td><?php echo $i++; ?></td>
        <td><?php echo $row['no_surat']; ?></td>
        <td><?php echo $row['judul_surat']; ?></td>
        <td><?php echo $row['tgl_surat']; ?></td>
        <td><?php echo $row['jenis_surat']; ?></td>
        <td><?php echo $row['tujuan']; ?></td>
        <td><?php echo $row['karyawan']; ?></td>
        <td>
          <?php if($row['file_surat']): ?>
            <a href="download.php?type=keluar&file=<?php echo urlencode($row['file_surat']); ?>">Download</a>
            | <a href="<?php echo UPLOAD_KELUAR_URL . $row['file_surat']; ?>" target="_blank">Lihat</a>
          <?php else: echo '-'; endif; ?>
        </td>
        <td>
          <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus surat?')">Hapus</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<!-- Modal Tambah Surat -->
<div class="modal fade" id="modalAdd" tabindex="-1">
  <div class="modal-dialog">
    <form method="post" enctype="multipart/form-data" class="modal-content">
      <div class="modal-header">
        <h5>Tambah Surat Keluar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3"><label>No Surat</label><input name="no_surat" class="form-control" required></div>
        <div class="mb-3"><label>Judul Surat</label><input name="judul_surat" class="form-control" required></div>
        <div class="mb-3"><label>Tgl Surat</label><input type="date" name="tgl_surat" class="form-control" required></div>
<div class="mb-3">
  <label>Jenis Surat</label>
  <input type="text" name="jenis_surat" class="form-control" >
</div>
<div class="mb-3">
  <label>Tujuan</label>
  <select name="tujuan" class="form-control" required>
    <option value="">-- Pilih Tujuan --</option>
    <option value="Badan Perencanaan, Penelitian dan Pengembangan">Badan Perencanaan, Penelitian dan Pengembangan</option>
    <option value="Badan Kepegawaian dan Pengembangan SDM">Badan Kepegawaian dan Pengembangan SDM</option>
    <option value="Badan Pengelola Keuangan dan Pendapatan">Badan Pengelola Keuangan dan Pendapatan</option>
    <option value="Badan Penanggulangan Bencana Daerah">Badan Penanggulangan Bencana Daerah</option>
    <option value="Dinas Pendidikan">Dinas Pendidikan</option>
    <option value="Dinas Kesehatan">Dinas Kesehatan</option>
    <option value="Dinas Pekerjaan Umum dan Penataan Ruang">Dinas Pekerjaan Umum dan Penataan Ruang</option>
    <option value="Dinas Perumahan Rakyat dan Kawasan Permukiman">Dinas Perumahan Rakyat dan Kawasan Permukiman</option>
    <option value="Dinas Sosial">Dinas Sosial</option>
    <option value="Dinas Ketenagakerjaan">Dinas Ketenagakerjaan</option>
    <option value="Dinas Pemberdayaan Perempuan dan Perlindungan Anak">Dinas Pemberdayaan Perempuan dan Perlindungan Anak</option>
    <option value="Dinas Ketahanan Pangan">Dinas Ketahanan Pangan</option>
    <option value="Dinas Lingkungan Hidup">Dinas Lingkungan Hidup</option>
    <option value="Dinas Kependudukan dan Pencatatan Sipil">Dinas Kependudukan dan Pencatatan Sipil</option>
    <option value="Dinas Pemberdayaan Masyarakat dan Desa">Dinas Pemberdayaan Masyarakat dan Desa</option>
    <option value="Dinas Pengendalian Penduduk dan Keluarga Berencana">Dinas Pengendalian Penduduk dan Keluarga Berencana</option>
    <option value="Dinas Komunikasi dan Informatika">Dinas Komunikasi dan Informatika</option>
    <option value="Dinas Perhubungan">Dinas Perhubungan</option>
    <option value="Dinas Penanaman Modal dan Perizinan Terpadu Satu Pintu">Dinas Penanaman Modal dan Perizinan Terpadu Satu Pintu</option>
    <option value="Dinas Perdagangan">Dinas Perdagangan</option>
    <option value="Dinas Pemuda, Olahraga dan Pariwisata">Dinas Pemuda, Olahraga dan Pariwisata</option>
    <option value="Dinas Koperasi, UKM, Perindustrian dan Perdagangan">Dinas Koperasi, UKM, Perindustrian dan Perdagangan</option>
    <option value="Dinas Perpustakaan">Dinas Perpustakaan</option>
    <option value="Kesatuan Bangsa dan Politik">Kesatuan Bangsa dan Politik</option>
    <option value="Satuan Polisi Pamong Praja">Satuan Polisi Pamong Praja</option>
    <option value="Kecamatan PSP Selatan">Kecamatan PSP Selatan</option>
    <option value="Kecamatan PSP Utara">Kecamatan PSP Utara</option>
    <option value="Kecamatan PSP Batunadua">Kecamatan PSP Batunadua</option>
    <option value="Kecamatan PSP HutaImbaru">Kecamatan PSP HutaImbaru</option>
    <option value="Kecamatan PSP Tenggara">Kecamatan PSP Tenggara</option>
    <option value="Kecamatan Angkola Julu">Kecamatan Angkola Julu</option>
    <option value="Sekretariat Daerah Kota PSP">Sekretariat Daerah Kota PSP</option>
    <option value="RSUD">RSUD</option>
    <option value="Inspektorat Kota PSP">Inspektorat Kota PSP</option>
    <option value="Sekretariat DPRD">Sekretariat DPRD</option>
  </select>
</div>
<div class="mb-3">
  <label>Karyawan</label>
  <input type="text" name="karyawan" class="form-control" placeholder="Masukkan nama karyawan" required>
</div>

        <div class="mb-3"><label>File (PDF, max 2MB)</label><input type="file" name="file_surat" class="form-control" accept="application/pdf"></div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="addKeluar" class="btn" style="background:#0d47a1;color:#fff">Simpan</button>
      </div>
    </form>
  </div>
</div>

<script>
$(document).ready(function(){
  $('#tblKeluar').DataTable();
});
</script>

<?php include 'footer.php'; ?>
<?php include 'style.php'; ?>
