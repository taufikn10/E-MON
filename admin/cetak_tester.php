<?php

require_once __DIR__ . '/vendor/autoload.php';
// MENGHUBUNGKAN KONEKSI DATABASE
require "koneksi_admin.php";
$testers = query("SELECT * FROM tb_bio_tester");

$mpdf = new \Mpdf\Mpdf();
$mpdf->AddPage('c', 'A4-L');

$html = '<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tester</title>
</head>
<body>
  <h1>Tester</h1>
      <table id="example" border="1" cellpadding="10" cellspasing="10">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Tester</th>
            <th>Email</th>
            <th>Nip</th>
            <th>Tanggal Lahir</th>
            <th>Jenis Kelamin</th>
            <th>Jabatan</th>
            <th>Alamat</th>
            <th>Kab/Kota</th>
            <th>Provinsi</th>
            <th>Telepon</th>
            <th>Foto</th>
          </tr>
        </thead>';
       $no = 1;
       foreach ($testers as $tester){
         $html .= '<tr>
            <th>'. $no++ . '</th>
            <td>' . $tester["nama_lengkap"] . '</td>
            <td>' . $tester["email_tester"] . '</td>
            <td>' . $tester["nip"] . '</td>
            <td>' . $tester["ttl"] . '</td>
            <td>' . $tester["jenis_kelamin"] . '</td>
            <td>' . $tester["jabatan"] . '</td>
            <td>' . $tester["alamat"] . '</td>
            <td>' . $tester["kab_kota"] . '</td>
            <td>' . $tester["provinsi"] . '</td>
            <td>' . $tester["telepon"] . '</td>
            <td><img src="../data/profile_tester/'. $tester["foto"]. '" width="70"></td>
         </tr>';

       }


$html .=  '</table>
</body>
</html>';

$mpdf->WriteHTML($html);
$mpdf->Output('tester.pdf', 'I');
?>

