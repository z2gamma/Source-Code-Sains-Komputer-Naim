<?php
session_start();
$pelayan = "localhost";
$penggunapelayan = "root";
$katalaluanpelayan = "";
$pangkalandata = "naim";

$sambungan = mysqli_connect($pelayan, $penggunapelayan, $katalaluanpelayan, $pangkalandata);

if(!$sambungan){
	echo "Gagal membuat sambungan kerana: ".mysqli_connect_error($sambungan);
}else{

}
error_reporting(E_ALL ^ E_NOTICE);
?>
