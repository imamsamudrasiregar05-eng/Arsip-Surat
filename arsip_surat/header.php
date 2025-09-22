<?php
// header.php - include where page output begins (assumes init.php already included)
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistem Arsip Surat</title>
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- FontAwesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <!-- DataTables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  <style>
    :root {
      --primary-dark: #0d47a1;
      --primary-light: #42a5f5;
      --background: img: url('assets/img/logo.png') no-repeat center center fixed;
    }
    body { font-family: 'Poppins', sans-serif; background: var(--background); }
    .sidebar { background: linear-gradient(180deg, var(--primary-dark), var(--primary-light)); min-height:100vh; color:#fff; }
    .sidebar a { color:#fff; display:block; padding:10px 15px; border-radius:8px; text-decoration:none; margin-bottom:6px; }
    .sidebar a:hover { background: rgba(255,255,255,0.08); }
    .card { border-radius:12px; box-shadow:0 2px 6px rgba(0,0,0,0.08); }
    .topbar { background: #fff; padding:10px 20px; border-bottom:1px solid #e9eef5; }
  </style>
</head>
<body>
