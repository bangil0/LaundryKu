<?php

session_start();
include 'connect-db.php';

if ( !(isset($_SESSION["login-admin"])) ){
    if ( !(isset($_SESSION["admin"])) ){
        echo "
            <script>
                alert('Belum Login Sebagai Admin !');
                document.location.href = 'index.php';
            </script>
        ";
        exit;
    }
}

//konfirgurasi pagination
$jumlahDataPerHalaman = 3;
$query = mysqli_query($connect,"SELECT * FROM agen");
$jumlahData = mysqli_num_rows($query);
//ceil() = pembulatan ke atas
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);

//menentukan halaman aktif
//$halamanAktif = ( isset($_GET["page"]) ) ? $_GET["page"] : 1; = versi simple
if ( isset($_GET["page"])){
    $halamanAktif = $_GET["page"];
}else{
    $halamanAktif = 1;
}

//data awal
$awalData = ( $jumlahDataPerHalaman * $halamanAktif ) - $jumlahDataPerHalaman;

//fungsi memasukkan data di db ke array
$agen = mysqli_query($connect,"SELECT * FROM agen LIMIT $awalData, $jumlahDataPerHalaman");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "headtags.html"; ?>
    <title>Data Agen</title>
</head>
<body>

    <!-- header -->
    <?php include 'header.php'; ?>
    <!-- end header -->


    <h3 class="header light center">List Agen</h3>
    <br>
        <div class="container">
            
            <!-- pagination -->
            <ul class="pagination center">
            <?php if( $halamanAktif > 1 ) : ?>
                <li class="disabled-effect blue darken-1">
                    <!-- halaman pertama -->
                    <a href="?page=<?= $halamanAktif - 1; ?>"><i class="material-icons">chevron_left</i></a>
                </li>
            <?php endif; ?>
            <?php for( $i = 1; $i <= $jumlahHalaman; $i++ ) : ?>
                <?php if( $i == $halamanAktif ) : ?>
                    <li class="active grey"><a href="?page=<?= $i; ?>"><?= $i ?></a></li>
                <?php else : ?>
                    <li class="waves-effect blue darken-1"><a href="?page=<?= $i; ?>"><?= $i ?></a></li>
                <?php endif; ?>
            <?php endfor; ?>
            <?php if( $halamanAktif < $jumlahHalaman ) : ?>
                <li class="waves-effect blue darken-1">
                    <a class="page-link" href="?page=<?= $halamanAktif + 1; ?>"><i class="material-icons">chevron_right</i></a>
                </li>
            <?php endif; ?>
            </ul>
            <!-- pagination -->
        
            <!-- data agen -->
            <table cellpadding=10 border=1>
                <tr>
                    <th>ID Agen</th>
                    <th>Nama Laundry</th>
                    <th>Nama Pemilik</th>
                    <th>No Telp</th>
                    <th>Email</th>
                    <th>Plat Driver</th>
                    <th>Kota</th>
                    <th>Alamat Lengkap</th>
                    <th>Aksi</th>
                </tr>

                <?php foreach ($agen as $dataAgen) : ?>
                
                <tr>
                    <td><?= $dataAgen["id_agen"] ?></td>
                    <td><?= $dataAgen["nama_laundry"] ?></td>
                    <td><?= $dataAgen["nama_pemilik"] ?></td>
                    <td><?= $dataAgen["telp"] ?></td>
                    <td><?= $dataAgen["email"] ?></td>
                    <td><?= $dataAgen["plat_driver"] ?></td>
                    <td><?= $dataAgen["kota"] ?></td>
                    <td><?= $dataAgen["alamat"] ?></td>
                    <td><a href="hapus-agen.php?id=<?= $dataAgen['id_agen'] ?>">Hapus Data</a></td>
                </tr>

                <?php endforeach ?>
            </table>
            <!-- end data agen -->



        </div>
        
    </div>

    <!-- footer -->
    <?php include "footer.php"; ?>
    <!-- end footer -->
</body>
</html>