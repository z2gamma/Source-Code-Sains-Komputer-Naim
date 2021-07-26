<?php
require_once("connection/connection.php");
?>
<?php
//Mendapatkan isyarat dari form formlogmasuk di html
if (isset($_POST["logmasuk"])) {
    $idpengurus = mysqli_real_escape_string($sambungan, $_POST["idpengurus"]);
    $katalaluan = mysqli_real_escape_string($sambungan, $_POST["katalaluan"]);
    //Proses validasi idpengurus dan katalaluan
    $sqllogmasuk = "SELECT * FROM pengurus WHERE pengurus.idpengurus = '$idpengurus' AND pengurus.katalaluan = '$katalaluan'";
    $querylogmasuk = mysqli_query($sambungan, $sqllogmasuk);
    $keputusan = mysqli_num_rows($querylogmasuk);
    if ($keputusan == 1) {
        $_SESSION["logmasuk"] = true;
        $_SESSION["idpengurus"] = mysqli_fetch_assoc($querylogmasuk)["idpengurus"];
        //Sekiranya validasi idpengurus dan katalaluan berjaya, papar pop up dan bawa pengguna ke halaman yang dikehendaki
        echo "<script>alert('Log masuk berjaya, selamat datang')</script>";
        if (isset($_GET["halaman"])) {
            $halaman_redirect = base64_decode($_GET["halaman"]);
            echo "<script>window.location.href='$halaman_redirect'</script>";
        } else {
            $_GET["halaman"] = "L25haW0v";
            $halaman_redirect = base64_decode($_GET["halaman"]);
            echo "<script>window.location.href='$halaman_redirect'</script>";
        }
    } else {
        //Sekiranya validasi gagal, pengurus dikehendaki kembali ke log masuk
        echo "<script>alert('Log masuk gagal, sila cuba sekali lagi')</script>";
    }
}
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Log masuk</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <link rel="stylesheet" href="css/log_masuk.css">
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
          </ul>
        </div>
      </nav>
    </div>
    <div id="body">
      <br>
      <div id="btnsaizfont">
        <center>
          <button id="besarkan" class="btn btn-outline-primary">A+</button>&nbsp;<span><button id="kecilkan" class="btn btn-outline-primary">A-</button></span>
        </center>
      </div>
      <br>
      <div id="form">
        <form name="formlogmasuk" method="post">
          <label>ID pengurus<span class="text-danger"> *</span></label>
          <input type="text" name="idpengurus" class="form-control" placeholder="Sila masukkan ID pengurus" autocomplete="off">
          <label>Password<span class="text-danger"> *</span></label>
          <input type="password" name="katalaluan" class="form-control" placeholder="Sila masukkan kata laluan" autocomplete="off"><br>
          <input type="submit" name="logmasuk" class="btn btn-primary" value="Log masuk"><span>&nbsp;<input type="reset" name="setsemula" class="btn btn-danger" value="Set semula"></span><br>
          <a>Tiada IDPengurus? <a href="pendaftaran_pengurus.php">tekan saya!</a> untuk mendaftarkan pengurus baharu</a>
        </form>
      </div>
      <script type="text/javascript">
        $("#besarkan").click(function() {
          $("form,label,input").css("font-size", (parseInt($("form,label,input").css("fontSize")) + 2) + "px");
        });
        $("#kecilkan").click(function() {
          $("form,label,input").css("font-size", (parseInt($("form,label,input").css("fontSize")) - 2) + "px");
        });
      </script>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
</body>

</html>
