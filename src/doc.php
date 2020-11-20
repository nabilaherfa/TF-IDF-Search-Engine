<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php  
$dokumen = "dokumen/"; 
if(!($buka_folder = opendir($dokumen))) die ("Error Brow!");

$file_array = array();
while($baca_folder = readdir($buka_folder))
 {
  if(substr($baca_folder,0,1) != '.')
   {
     $file_array[] =  $baca_folder;
    }
 } ?>
 <br><br>
 <h1> UPLOADED DOCUMENT </h1>
 <?php
 while(list($index, $namafile) = each($file_array))
  {
   $nomor = $index + 1;
   echo "$nomor. <a href='dokumen/$namafile'>$namafile</a>";
   echo "<br>";
 }
closedir($buka_folder);
?>
</body>
</html>