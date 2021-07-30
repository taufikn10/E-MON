<?php

require_once __DIR__ . '/vendor/autoload.php';
// MENGHUBUNGKAN KONEKSI DATABASE
require "koneksi_admin.php";
$college = query("SELECT * FROM tb_bio_mhs ORDER BY nim ASC");

$mpdf = new \Mpdf\Mpdf();
$mpdf->AddPage('c', 'A4-L');

$html = '<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>College Students</title>
</head>
<body>
  <h1> College Students </h1>
      <table id="example" border="1" cellpadding="10" cellspasing="10">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Mahasiswa</th>
            <th>Email</th>
            <th>Nim</th>
            <th>Tanggal Lahir</th>
            <th>Jenis Kelamin</th>
            <th>Prodi</th>
            <th>Jurusan</th>
            <th>Alamat</th>
            <th>Kab/Kota</th>
            <th>Provinsi</th>
            <th>Telepon</th>
            <th>Foto</th>
          </tr>
        </thead>';
       $no = 1;
       foreach ($college as $mhs){
         $html .= '<tr>
            <th>' . $no++ . '</th>
            <td>' . $mhs["nama_depan"] . " " . $mhs["nama_belakang"] . '</td>
            <td>' . $mhs["email_mhs"] . '</td>
            <td>' . $mhs["nim"]. '</td>
            <td>' . $mhs["ttl"]. '</td>
            <td>' . $mhs["jenis_kelamin"] . '</td>
            <td>' . $mhs["prodi"] . '</td>
            <td>' . $mhs["jurusan"] . '</td>
            <td>' . $mhs["alamat"] . '</td>
            <td>' . $mhs["kab_kota"] . '</td>
            <td>' . $mhs["provinsi"] . '</td>
            <td>' . $mhs["telepon"] . '</td>
            <td><img src="../data/profile_mhs/'.  $mhs["foto"]. '" width="70"></td>
         </tr>';



         
       }


$html .=  '</table>
</body>
</html>';

$mpdf->WriteHTML($html);
$mpdf->Output('collegeStudents.pdf', 'I');
?>