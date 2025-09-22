<?php
require 'init.php';
require 'config.php';
ensure_login();
include 'header.php';
include 'sidebar.php';

// add disposisi
if (isset($_POST['addDispo'])) {
    $id_surat = (int)$_POST['id_surat'];
    $ditujukan = $koneksi->real_escape_string($_POST['ditujukan']);
    $instruksi = $koneksi->real_escape_string($_POST['instruksi']);
    $tgl = $koneksi->real_escape_string($_POST['tgl_disposisi']);
    $koneksi->query("INSERT INTO disposisi (id_surat, ditujukan, instruksi, tgl_disposisi) VALUES ($id_surat,'".$ditujukan."','".$instruksi."','".$tgl."')");
    header('Location: disposisi.php'); exit;
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $koneksi->query("DELETE FROM disposisi WHERE id=$id");
    header('Location: disposisi.php'); exit;
}

$data = $koneksi->query("SELECT d.*, s.no_surat FROM disposisi d LEFT JOIN surat_masuk s ON s.id=d.id_surat ORDER BY d.tgl_disposisi DESC");
$surat = $koneksi->query("SELECT id,no_surat FROM surat_masuk ORDER BY created_at DESC");
?>

<h3>Disposisi</h3>
<div class="mb-3"><button class="btn" style="background:#0d47a1;color:#fff" data-bs-toggle="modal" data-bs-target="#modalAdd">Tambah Disposisi</button></div>

<div class="card p-3">
  <table id="tblDispo" class="table table-striped">
    <thead><tr><th>#</th><th>No Surat</th><th>Ditujukan</th><th>Instruksi</th><th>Tgl Disposisi</th><th>Aksi</th></tr></thead>
    <tbody>
      <?php $i=1; while($r = $data->fetch_assoc()): ?>
      <tr>
        <td><?php echo $i++; ?></td>
        <td><?php echo $r['no_surat']; ?></td>
        <td><?php echo $r['ditujukan']; ?></td>
        <td><?php echo $r['instruksi']; ?></td>
        <td><?php echo $r['tgl_disposisi']; ?></td>
        <td><a href="?delete=<?php echo $r['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus?')">Hapus</a></td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<!-- modal -->
<div class="modal fade" id="modalAdd" tabindex="-1">
  <div class="modal-dialog">
    <form method="post" class="modal-content">
      <div class="modal-header"><h5>Tambah Disposisi</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <div class="mb-3"><label>Pilih Surat</label>
          <select name="id_surat" class="form-control">
            <?php while($s = $surat->fetch_assoc()): ?>
              <option value="<?php echo $s['id']; ?>"><?php echo $s['no_surat']; ?></option>
            <?php endwhile; ?>
          </select>
        </div>
        <div class="mb-3"><label>Ditujukan</label><input name="ditujukan" class="form-control"></div>
        <div class="mb-3"><label>Instruksi</label><textarea name="instruksi" class="form-control"></textarea></div>
        <div class="mb-3"><label>Tanggal Disposisi</label><input type="date" name="tgl_disposisi" class="form-control"></div>
      </div>
      <div class="modal-footer"><button name="addDispo" class="btn" style="background:#0d47a1;color:#fff">Simpan</button></div>
    </form>
  </div>
</div>

<script>$(document).ready(function(){ $('#tblDispo').DataTable(); });</script>
<?php include 'footer.php'; ?>

<?php include 'style.php'; ?>