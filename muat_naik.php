<?php
require_once("connection/connection.php");
?>
<?php
//Validasi Log masuk daripada pengguna
if ($_SESSION["logmasuk"] == false) {
    //Nyahkod url daripada halaman log masuk
    $url = base64_encode($_SERVER['REQUEST_URI']);
    //Sekiranya pengguna belum log masuk, pengguna akan kembali ke log_masuk.php
    echo "<script>alert('Sila log masuk untuk menggunakan sistem');window.location.href='log_masuk.php?halaman=$url'</script>";
}
?>
<?php
//Proses log keluar
//Pembolehubah butang log keluar
$logkeluar = $_SERVER['PHP_SELF']."?logkeluar=1";
//Proses sekiranya butang "Log Keluar" ditekan
if (isset($_GET["logkeluar"])) {
    if ($_GET["logkeluar"] == 1) {
        //Sekiranya log keluar berjaya pengguna akan kembali ke log_masuk.php
        echo "<script>alert('Selamat tinggal');window.location.href='log_masuk.php'</script>";
        session_destroy();
    } else {
        $_GET["logkeluar"] == 0;
    }
}
?>
<?php
if (isset($_POST["muatnaik"])) {
    $filename = $_FILES["file-input"]["tmp_name"];
    $filename1 = $_FILES["file-input"]["name"];
    $filesize = $_FILES["file-input"]["size"];
    if ($filename = "") {
        echo "<script>alert('Sila pilih file CSV anda')</script>";
    } else {
        $file = fopen($filename1, "r");
        if (($column = fgetcsv($file, 10000, ",")) !== false) {
            $sqlmuatnaikpelanggan = "INSERT INTO pelanggan(nama,no_kp,kod_kategori) VALUES('".$column[0]."','".$column[1]."','".$column[2]."')";
            $querymuatnaikpelanggan = mysqli_query($sambungan, $sqlmuatnaikpelanggan);
            $sqlmuatnaikbeli = "INSERT INTO beli(no_kp,id_tiket) VALUES('".$column[1]."','".$column[3]."')";
            $querymuatnaikbeli = mysqli_query($sambungan, $sqlmuatnaikbeli);
            if ($querymuatnaikbeli) {
                echo "<script>alert('Muat naik berjaya, anda akan dibawa ke paparan pelanggan');window.location.href='paparan_pelanggan.php'</script>";
            } else {
                echo "<script>alert('Muat naik gagal, sila cuba lagi');window.location.href='muat_naik.php'</script>";
            }
        }
    }
}
?>
<!doctype html>
<html lang="ms">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Muat naik</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <link rel="stylesheet" href="css/muat_naik.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
  <div id="wrapper">
    <div id="banner">
      <div>
        <h2 id="banner-text">Sistem Tempahan Tiket Bas Z2<span class="text-primary">Corp</span></h2>
      </div>
    </div>
    <div id="navbar">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand font-weight-bold" href="#">Z2<span>Corp</span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="index.php">
                <img src="gambar/main_menu.png" width="32px" height="32px" style="margin: 0 auto; display: block;">
                <p class="">Halaman utama</p>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pendaftaran_pelanggan.php">
                <img src="gambar/register.png" width="32px" height="32px" style="margin: 0 auto; display: block;">
                <p>Pendaftaran pelanggan</p>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="paparan_pelanggan.php">
                <img src="gambar/table.png" width="32px" height="32px" style="margin: 0 auto; display: block;">
                <p>Paparan pelanggan</p>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="carian_pelanggan.php">
                <img src="gambar/search.png" width="32px" height="32px" style="margin: 0 auto; display: block;">
                <p>Carian Pelanggan</p>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="statistik.php">
                <img src="gambar/calculator.png" width="32px" height="32px" style="margin: 0 auto; display: block;">
                <p>Statistik</p>
              </a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="muat_naik.php">
                <img src="gambar/upload.png" width="32px" height="32px" style="margin: 0 auto; display: block;">
                <p>Muat Naik</p>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo $logkeluar?>">
                <img src="gambar/logout.png" width="32px" height="32px" style="margin: 0 auto; display: block;">
                <p class="text-danger">Log Keluar</p>
              </a>
            </li>
          </ul>
        </div>
      </nav>
    </div>
    <div id="body" class="bg-light">
      <br>
      <div id="btnsaizfont">
        <center>
          <button id="besarkan" class="btn btn-outline-primary">A+</button>&nbsp;<span><button id="kecilkan" class="btn btn-outline-primary">A-</button></span>
        </center>
      </div>
      <br>
      <div id="file">
        <center>
          <form method="post" id="form" enctype="multipart/form-data">
            <div>
              <input type="file" id="file-input" accept=".csv" name="file-input">
            </div>
            <br>
            <input type="submit" value="Muat naik" class="btn btn-primary" name="muatnaik">
          </form>
          <br>
          <a>Perlukan contoh CSV? <a href="contoh.csv">Tekan saya</a> untuk download contoh anda</a>
        </center>
      </div>
      <script type="text/javascript">
        $("#besarkan").click(function() {
          $("form,label,input,select").css("font-size", (parseInt($("form,label,input,select").css("fontSize")) + 2) + "px");
        });
        $("#kecilkan").click(function() {
          $("form,label,input,select").css("font-size", (parseInt($("form,label,input,select").css("fontSize")) - 2) + "px");
        });
      </script>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
</body>

</html>
