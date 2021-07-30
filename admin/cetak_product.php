<?php

require_once __DIR__ . '/vendor/autoload.php';
// MENGHUBUNGKAN KONEKSI DATABASE
require "koneksi_admin.php";
$products = query("SELECT tb_products.*, tb_bio_mhs.* FROM tb_products INNER JOIN tb_bio_mhs ON tb_products.id_mhs = tb_bio_mhs.id_mhs;");



$mpdf = new \Mpdf\Mpdf();
$mpdf->AddPage('c', 'A4-L');

$html =
'<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Product</title>
  <style>
  th {
    font-family:Courier New, Courier, monospace; 
    font: size 14px;   
    font-weight: bold;
  }
  td {
  font-family: Assistant , sans-serif;
  font-size: 10px;
  }
  </style>
</head>
<body>
  <h1> Daftar Product </h1>
      <table id="example"  border="1" cellpadding="10" cellspasing="0">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Tim</th>
            <th>Ketua</th>
            <th>Judul Products</th>
            <th>Deskripsi Produk</th>
            <th>Foto Products</th>
            <th colspan = "5" >Anggota</th>


          </tr>
        </thead>';
                      
       $no = 1;
       foreach ($products as $product){
         $html .= '<tr>
            <th>'. $no++ . '</th>
            <td>' . $product["nama_tim"] . '</td>
            <td>' . $product["nama_depan"] . " " . $product["nama_belakang"] . '</td>
            <td>' . $product["judul_prod"] . '</td>
            <td>' . $product["deskripsi_prod"] . '</td>
            <td>';
            

            $prod = $product["id_product"];
            $product_thumbnails = query("SELECT * FROM tb_product_thumbnails WHERE id_product = '$prod' ;");
            foreach ($product_thumbnails as $tb){
             $html .= '<img src="../data/profile_product/'. $tb['thumb_prod']. '" width="100"><br><br>';
            }
            '</td>
            ';
           
            $prod = $product["id_product"];
            $product_members = query("SELECT tb_product_members.*, tb_bio_mhs.* FROM tb_product_members INNER JOIN tb_bio_mhs ON tb_product_members.id_mhs = tb_bio_mhs.id_mhs WHERE id_product = '$prod';");
            foreach ($product_members as $member){
             $html .= '<td>' . $member["nama_depan"] . " " . $member["nama_belakang"] . '<br>';
            }
            '</td>
            </tr>';
}
     

$html .=  '
</table>
</body>
</html>';

$mpdf->WriteHTML($html);
$mpdf->Output('product.pdf', 'I');
?>