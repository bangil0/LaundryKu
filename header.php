<div id="header">
    <ul>
        <li><a href="index.php"><b>Home</b></a></li>
        <li>
            <?php
                global $connect;

                if ( isset($_SESSION["login-pelanggan"]) && isset($_SESSION["pelanggan"])){
                    // mengambil email dari session
                    $idPelanggan = $_SESSION["pelanggan"];
                    // cari data di db sesuai $email
                    $data = mysqli_query($connect, "SELECT * FROM pelanggan WHERE id_pelanggan = '$idPelanggan'");
                    // memasukkan ke array asosiatif
                    $data = mysqli_fetch_assoc($data);
                    // mengambil data nama dari array
                    $nama = $data["nama"];

                    echo "
                        <a href='pelanggan.php'><b>$nama</b></a> (Pelanggan)
                    ";
                }else if ( isset($_SESSION["login-agen"]) && isset($_SESSION["agen"])){
                    // mengambil email dari session
                    $id_agen = $_SESSION["agen"];
                    // cari data di db sesuai $id_agen
                    $data = mysqli_query($connect, "SELECT * FROM agen WHERE id_agen = '$id_agen'");
                    // memasukkan ke array asosiatif
                    $data = mysqli_fetch_assoc($data);
                    // mengambil data nama dari array
                    $nama = $data["nama_laundry"];

                    echo "
                        <a href='agen.php'><b>$nama</b></a> (Agen)
                    ";
                }else if ( isset($_SESSION["login-admin"]) && isset($_SESSION["admin"])){
                    echo "
                        <a href='admin.php'><b>Admin</b></a> (Admin)
                    ";
                }else {
                    echo "
                        <a href='registrasi.php'><b>Registrasi</b></a>
                    ";
                }
            ?>
        </li>
        <li>
            <?php
                if ( isset($_SESSION["login-pelanggan"]) && isset($_SESSION["pelanggan"]) || isset($_SESSION["login-agen"]) && isset($_SESSION["agen"]) || isset($_SESSION["login-admin"]) && isset($_SESSION["admin"]) ){
                    echo "
                        <a href='logout.php'><b>Logout</b></a>
                    ";
                }else {
                    echo "
                        <a href='login.php'><b>Login</b></a>
                    ";
                }
            ?>
        </li>
    </ul>
</div>