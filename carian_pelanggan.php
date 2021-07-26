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
//Proses mendapatkan nilai halaman
if (isset($_GET['halaman'])) {
    $halaman = mysqli_real_escape_string($sambungan, $_GET["halaman"]);
//Sekiranya nilai halaman adalah 1
} else {
    $halaman = 1;
}
$limitrekod = 5;
$offset = ($halaman - 1) * $limitrekod;
$sqllimit = "SELECT COUNT(*) FROM beli";
$querylimit = mysqli_query($sambungan, $sqllimit);
$jumlah_rows = mysqli_fetch_array($querylimit)[0];
$jumlah_halaman = ceil($jumlah_rows / $limitrekod);
//Melaksanakan arahan daripada input yang diterima
if (isset($_GET["carinama"])) {
    $nama = mysqli_real_escape_string($sambungan, $_GET["nama"]);
}
//Proses mendapatkan rekod-rekod pelanggan dari pangkalan data
$sqlcarian = "SELECT * FROM beli JOIN pelanggan ON beli.no_kp = pelanggan.no_kp JOIN tiket ON beli.id_tiket = tiket.id_tiket JOIN kategori ON pelanggan.kod_kategori = kategori.kod_kategori WHERE pelanggan.nama LIKE '%$nama%' LIMIT $offset,$limitrekod";
$querycarian = mysqli_query($sambungan, $sqlcarian);
//Mengira jumlah rekod dari pangkalan data
$jumlah = mysqli_num_rows($querycarian);
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Carian pelanggan</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <link rel="stylesheet" href="css/carian_pelanggan.css">
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
            <li class="nav-item active">
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
            <li class="nav-item">
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
      <div id="tablediv">
        <form method="get" class="form" id="formcarian">
          <input name="nama" class="form-control border-dark" placeholder="Sila masukkan nama pelanggan yang ingin dicari" autocomplete="off"><br>
          <input type="submit" name="carinama" class="btn btn-primary" value="Buat Carian">
        </form><br>
        <table class="table table-bordered border-dark rounded" border="1" id="table">
          <tr id="pelanggan">
            <td>Nama pelanggan</td>
            <td>No kad pengenalan</td>
            <td>Kategori</td>
            <td>Mula - Destinasi</td>
          </tr>
          <?php while ($rows = mysqli_fetch_assoc($querycarian)) {?>
          <tr id="pelanggan">
            <td><?php echo $rows["nama"];?></td>
            <td><?php echo $rows["no_kp"];?></td>
            <td><?php echo $rows["kategori"];?></td>
            <td><?php echo $rows["muladestinasi"];?></td>
          </tr>
          <?php } ?>
        </table>
        <br>
        <table class="table table-bordered" id="table">
          <tr>
            <td>Memaparkan rekod <?php echo $offset + 1 ?> hingga <?php echo max($offset + $jumlah, $halaman) ?> daripada <?php echo $jumlah_rows ?> kumulatif rekod </td>
            <td align="center"><a href="carian_pelanggan.php?nama=<?php echo $nama ?>&halaman=1">Awal<a></td>
            <td align="center"><a href="carian_pelanggan.php<?php if ($halaman == 1) {
    echo "?halaman=1";
} else {
    echo "?halaman=".($halaman - 1);
} ?>">Sebelum<a></td>
            <td align="center"><a href="carian_pelanggan.php<?php if ($halaman == $jumlah_halaman) {
    echo "?halaman=$jumlah_halaman";
} else {
    echo "?halaman=".($halaman + 1);
} ?>">Seterusnya<a></td>
            <td align="center"><a href="carian_pelanggan.php?halaman=<?php echo $jumlah_halaman ?>">Akhir<a></td>
          </tr>
        </table>
      </div>
      <script type="text/javascript">
        $("#besarkan").click(function() {
          $("input,table").css("font-size", (parseInt($("input,table").css("fontSize")) + 2) + "px");
        });
        $("#kecilkan").click(function() {
          $("input,table").css("font-size", (parseInt($("input,table").css("fontSize")) - 2) + "px");
        });
      </script>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
</body>

</html>
