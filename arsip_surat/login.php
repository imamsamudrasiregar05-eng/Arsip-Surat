<?php
require 'init.php';
require 'koneksi.php'; // koneksi ke database

// Jika sudah login, langsung ke dashboard
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

// Jika form dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Cek ke database
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['user'] = $username;
        header("Location: index.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
  <div class="card shadow-lg p-4" style="background: rgba(221, 205, 205, 0.5); color:#fff; width: 350px;"> 
    <h3 class="text-center mb-3">Login</h3>
    <?php if (!empty($error)) : ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <form method="post">
      <div class="mb-3">
        <label>Username</label>
        <input type="text" name="username" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button class="btn btn-primary w-100">Login</button>
    </form>
  </div>
</body>
</html>

<style>
  body {
    height: 100vh;
    margin: 0;
    background:linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), /* overlay gelap */
                url('assets/img/kominfo.jpg') no-repeat center center fixed;
    background-size: cover;
    @font-face {
        font-family: 'niagara';
        src: url('fonts/Niagara Solid Regular.ttf') format('ttf');
    }
    font-weight: bolder;
    font-family: 'niagara', Arial, sans-serif;
  }

<style>

<?php include 'footer.php'; ?>