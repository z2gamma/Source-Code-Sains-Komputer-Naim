<?php
//Mendapatkan fail connection.php daripada folder connection
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
//Atur cara pendaftaran pelanggan
//Mendapatkan arahan daripada butang "Daftarkan pelanggan"
if (isset($_POST["daftarpelanggan"])) {
    $namapelanggan = mysqli_real_escape_string($sambungan, $_POST["nama"]);
    $nokp = mysqli_real_escape_string($sambungan, $_POST["no_kp"]);
    $kategori = mysqli_real_escape_string($sambungan, $_POST["kategori"]);
    $muladestinasi = mysqli_real_escape_string($sambungan, $_POST["muladestinasi"]);
    //Meminta pengguna untuk mengisikan setiap input sekiranya terdapat input yang kosong
    if (empty($namapelanggan) || empty($nokp) || empty($kategori) || empty($muladestinasi)) {
        echo "<script>alert('Sila pastikan setiap ruangan diisi');window.location.href='pendaftaran_pelanggan.php'</script>";
    //Melaksanakan SQL dan Query sekiranya semua ruangan diisi
    } else {
        if (is_numeric($nokp)) {
            $sqlcaripelanggan = "SELECT * FROM pelanggan WHERE pelanggan.no_kp = '$nokp'";
            $querycaripelanggan = mysqli_query($sambungan, $sqlcaripelanggan);
            //Arahan mengira sama ada pelanggan mempunyai rekod di dalam pangkalan data
            $bilangan = mysqli_num_rows($querycaripelanggan);
            if ($bilangan == 1) {
                //Terus memasukkan rekod beli sekiranya rekod pelanggan ada di dalam pangkalan data
                $sqldaftarbeli = "INSERT INTO beli(no_kp,id_tiket) VALUES ('$nokp','$muladestinasi')";
                $querydaftarbeli = mysqli_query($sambungan, $sqldaftarbeli);
                if ($querydaftarbeli) {
                    echo "<script>alert('Pendaftaran berjaya, anda akan dibawa ke halaman paparan pelanggan');window.location.href='paparan_pelanggan.php'</script>";
                } else {
                    echo "<script>alert('Pendaftaran Gagal, sila cuba sekali lagi');window.location.href='pendaftaran_pelanggan.php'</script>";
                }
            } else {
                //Memasukkan rekod pelanggan dan seterusnya beli sekiranya tiada rekod pelanggan di dalam pangkalan data
                $sqldaftarpelanggan = "INSERT INTO pelanggan (nama,no_kp,kod_kategori) VALUES ('$namapelanggan','$nokp','$kategori')";
                $querydaftarpelanggan = mysqli_query($sambungan, $sqldaftarpelanggan);
                $sqldaftarbeli = "INSERT INTO beli(no_kp,id_tiket) VALUES ('$nokp','$muladestinasi')";
                $querydaftarbeli = mysqli_query($sambungan, $sqldaftarbeli);
                if ($querydaftarpelanggan && $querydaftarbeli) {
                    echo "<script>alert('Pendaftaran berjaya, anda akan dibawa ke halaman paparan pelanggan');window.location.href='paparan_pelanggan.php'</script>";
                } else {
                    echo "<script>alert('Pendaftaran Gagal, sila cuba sekali lagi');window.location.href='pendaftaran_pelanggan.php'</script>";
                }
            }
        } else {
            echo "<script>alert('No kad pengenalan pelanggan tidak sah');window.location.href='pendaftaran_pelanggan.php'</script>";
        }
    }
}
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pendaftaran pelanggan</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <link rel="stylesheet" href="css/pendaftaran_pelanggan.css">
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
            <li class="nav-item active">
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
      <div id="form">
        <br>
        <div id="btnsaizfont">
          <center>
            <button id="besarkan" class="btn btn-outline-primary">A+</button>&nbsp;<span><button id="kecilkan" class="btn btn-outline-primary">A-</button></span>
          </center>
        </div>
        <br>
        <form method="post" name="formdaftarpelanggan">
          <label>Nama pelanggan<span class="text-danger"> *</span></label>
          <input type="text" maxlength="50" autocomplete="off" class="form-control border-dark" name="nama" placeholder="Sila masukkan nama pelanggan"><br>
          <label>No kad pengenalan pelanggan<span class="text-danger"> *</span></label>
          <input type="text" maxlength="12" autocomplete="off" class="form-control border-dark" name="no_kp" placeholder="Sila masukkan no kad pengenalan pelanggan"><br>
          <label>Kategori pelanggan<span class="text-danger"> *</span></label>
          <div>
            <div id="radio" class="border border-dark rounded">
              <a>BIASA</a>
              <input type="radio" name="kategori" value="B"><span>
                <a>OKU</a>
                <input type="radio" name="kategori" value="O">
            </div></span>
          </div><br>
          <label>Destinasi pelanggan<span class="text-danger"> *</span></label>
          <select class="form-control border-dark" name="muladestinasi">
            <option value="" disabled selected>Sila pilih mula - destinasi pelanggan</option>
            <option value="01">KL - IPOH</option>
            <option value="02">KL - KUALA KANGSAR</option>
            <option value="03">KL - TAIPING</option>
            <option value="04">KL - BATU GAJAH</option>
            <option value="05">KL - BAGAN DATOH</option>
            <option value="06">KL - TANJUNG MALIM</option>
          </select><br>
          <input type="submit" value="Daftarkan pelanggan" class="btn btn-primary" name="daftarpelanggan"><span>&nbsp;<input type="reset" value="Set semula" class="btn btn-danger"></span>
        </form>
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
