<?php
require_once("connection/connection.php");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Hello</title>
</head>

<body>
	<form method="post" enctype="multipart/form-data" name="helo">
		<input type="file" accept=".csv" name="file">
		<input type="submit" name="test" value="test">
	</form>
	<?php
	if(isset($_POST["test"])){
		$filename = $_FILES["file"]["tmp_name"];
		$filename1 = $_FILES["file"]["name"];
		$filesize = $_FILES["file"]["size"];
		echo $filename1."<br>";
		echo $filename."<br>";
		echo $filesize;
		if($filename = ""){
			echo "bodoh eh?";
		}else{
			$file = fopen($filename1, "r");
			print_r($file);
			if(($column = fgetcsv($file,10000,",")) !== FALSE){
				echo "<br>".$column[0];
				echo "<br>".$column[1];
				echo "<br>".$column[2];
				echo "<br>".$column[3];
				$sqlmuatnaikpelanggan = "INSERT INTO pelanggan(nama,no_kp,kod_kategori) VALUES('".$column[0]."','".$column[1]."','".$column[2]."')";
				$querymuatnaikpelanggan = mysqli_query($sambungan,$sqlmuatnaikpelanggan);
				$sqlmuatnaikbeli = "INSERT INTO beli(no_kp,id_tiket) VALUES('".$column[1]."','".$column[3]."')";
				$querymuatnaikbeli = mysqli_query($sambungan,$sqlmuatnaikbeli);
				if($querymuatnaikbeli){
					echo "muat naik berjaya";
				}
			}
		}
	}
	?>
</body>
</html>