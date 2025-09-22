<?php
// sidebar.php - include after header; expects init.php included by caller
?>
<div class="d-flex">
  <nav class="sidebar col-2 p-3" 
       style="background: rgba(113, 85, 85, 0.5); color:#fff; min-height:100vh;"> 
       <!-- 0.5 = transparan setengah -->
       
    <div class="text-center mb-5">
      <img src="assets/img/logo.png" alt="logo" style="width:200px; margin-top:50px;">
    </div>

    <div style="margin-top:50px"> <!-- geser menu agak kebawah -->
      <a href="index.php" class="nav-link"><i class="fa fa-home me-2"></i> Dashboard</a>
      <a href="surat_masuk.php" class="nav-link"><i class="fa fa-inbox me-2"></i> Surat Masuk</a>
      <a href="surat_keluar.php" class="nav-link"><i class="fa fa-paper-plane me-2"></i> Surat Keluar</a>
      <a href="laporan.php" class="nav-link"><i class="fa fa-print me-2"></i> Laporan</a>
      <div class="container mt-5"> <a href="logout.php" class="btn btn-danger">Logout</a>
</div>

    </div>
  </nav>
  <div class="content p-4 col-10">
