<?php
$jumlahFile = count($_FILES['upload']['name']);
for($i=0; $i<$jumlahFile; $i++){
    $namafile = $_FILES['upload']['name'][$i];
    $tmp = $_FILES['upload']['tmp_name'][$i];
    $type = $_FILES['upload']['type'][$i];
    $error = $_FILES['upload']['error'][$i];
    $size = $_FILES['upload']['size'][$i];
    $dirUpload = "dokumen/";
    $dokumen = move_uploaded_file($tmp, $dirUpload.$namafile);
} header("location: index.html");
?>