<?php
require_once("connection/connection.php");
?>
<?php
//Mendapatkan isyarat dari form formpendaftaranpelanggan di html
if (isset($_POST["daftarpengurus"])) {
    $namapengurus = mysqli_real_escape_string($sambungan, $_POST['namapengurus']);
    $idpengurus = mysqli_real_escape_string($sambungan, $_POST['idpengurus']);
    $katalaluan = mysqli_real_escape_string($sambungan, $_POST['katalaluan']);
    //papar output sekiranya input adalah kosong
    if (empty($namapengurus) || empty($idpengurus) || empty($katalaluan)) {
        echo "<script>alert('Sila pastikan setiap ruangan diisi')</script>";
    //Proses memasukkan nilai input kedalam pangkalan data
    } else {
        $sqlpendaftaranpengurus = "INSERT INTO pengurus(nama_pengurus,idpengurus,katalaluan) VALUES ('$namapengurus','$idpengurus','$katalaluan')";
        $querypendaftaranpengurus = mysqli_query($sambungan, $sqlpendaftaranpengurus);
        if ($querypendaftaranpengurus) {
            echo "<script>alert('Pendaftaran berjaya');window.location.href='log_masuk.php'</script>";
        } else {
            echo "<script>alert('Pendaftaran tidak sah, sila cuba lagi')</script>";
        }
    }
}
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pendaftaran pengurus</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <link rel="stylesheet" href="css/pendaftaran_pengurus.css">
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
      <div id="form">
        <br>
        <form method="post" name="formpendaftaranpengurus" class="form">
          <label>Nama pengurus<span class="text-danger"> *</span></label>
          <input type="text" name="namapengurus" placeholder="Sila masukkan nama pengurus" class="form-control" maxlength="50" autocomplete="off">
          <label>ID Pengurus<span class="text-danger"> *</span></label>
          <input type="text" name="idpengurus" placeholder="Sila masukkan ID pengurus" class="form-control" maxlength="20" autocomplete="off">
          <label>Kata laluan<span class="text-danger"> *</span></label>
          <input type="password" name="katalaluan" placeholder="Sila masukkan kata laluan" class="form-control" maxlength="20" autocomplete="off"><br>
          <input type="submit" name="daftarpengurus" value="Daftar sekarang!" class="btn btn-primary"><span>&nbsp;<input type="reset" name="setsemula" value="Set semula" class="btn btn-danger"></span><br>
          <a>Kembali ke halaman <a href="log_masuk.php">log masuk</a></a>
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
