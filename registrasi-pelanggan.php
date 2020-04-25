<?php

    // koneksi ke db
    session_start();
    include 'connect-db.php';

    if ( isset($_SESSION["login-pelanggan"]) && isset($_SESSION["pelanggan"]) || isset($_SESSION["login-agen"]) && isset($_SESSION["agen"]) || isset($_SESSION["login-admin"]) && isset($_SESSION["admin"]) ) {
        echo "
            <script>
                alert('Anda Sudah Mendaftar !');
                document.location.href = 'index.php';
            </script>
        ";
        exit;
    }

    // fungsi registrasi
    function registrasi ($data) {
        global $connect;

        //mengambil data
        $nama = $data["nama"];
        $email = $data["email"];
        $noTelp = $data["noTelp"];
        $kota = $data["kota"];
        $alamat = $data["alamat"];
        $password = $data["password"];
        $password2 = $data["password2"];

        // enskripsi password
        $password = mysqli_real_escape_string($connect , $data["password"]);
        $password2 = mysqli_real_escape_string($connect , $data["password2"]);

        //cek username apakah ada yg sama
        
        $result = mysqli_query($connect, "SELECT email FROM pelanggan WHERE email = '$email'");
        if ( mysqli_fetch_assoc($result) ){ //jika ada (TRUE)
            echo "
                <script>
                    alert('Email Sudah Terdaftar :)');
                </script>
            ";
            // RETURN FALSE
            return false;
        }

        //cek konfirmasi password
        if ($password != $password2) {
            echo "
                <script>   
                    alert('Password Tidak Sama :)');
                </script>
            ";
            return false;
        }

        //enskripsi password
        $password = password_hash($password, PASSWORD_DEFAULT);
        

        //pastikan nomor hp hanya angka
        $noTelp = $data["noTelp"];
        // memecah no telp
        $noTelp = str_split($noTelp);
        $totalNoTelp = count($noTelp);

        // cek no hp
        for ($i=0 ; $i<$totalNoTelp ; $i++){
            // mengecek no telp harus angka
            if ($noTelp[$i] != "1" && $noTelp[$i] != "2" && $noTelp[$i] != "3" && $noTelp[$i] != "4" && $noTelp[$i] != "5" && $noTelp[$i] != "6" && $noTelp[$i] != "7" && $noTelp[$i] != "8" && $noTelp[$i] != "9" && $noTelp[$i] != "0"){
                $noTelp[$i] = "";
            }
        }

        // menggabungkan string
        $noTelp = implode($noTelp);

        // var_dump($password);
        // var_dump($noTelp); die;

        // masukkan data user ke db
        mysqli_query($connect, "INSERT INTO pelanggan VALUES ('','$nama','$email','$noTelp','$kota','$alamat','$password')");

        // RETURN TRUE
        return mysqli_affected_rows($connect);
    }


    // ketika tombol registrasi di klik
    if ( isset($_POST["registrasi"]) ){
        if ( registrasi($_POST) > 0 ) {

            $email = $_POST["email"];
            $query = mysqli_query($connect, "SELECT * FROM pelanggan WHERE email = '$email'");
            $pelanggan = mysqli_fetch_assoc($query);
            $_SESSION["pelanggan"] = $pelanggan["id_pelanggan"];
            $_SESSION["login-pelanggan"] = true;
            echo "
                <script>
                    alert('Registrasi Berhasil !!!');
                    document.location.href = 'index.php';
                </script>
            ";
        }else {
            echo mysqli_error($connect);
        }

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Pelanggan</title>
</head>
<body>
    <?php include 'header.php'; ?>
    <div id="body">
        <h3>Registrasi Pelanggan</h3>
        <form action="" method="POST">
            <ul>
                <li><input type="text" placeholder="Nama" name="nama"></li>
                <li><input type="text" placeholder="E-mail" name="email"></li>
                <li><input type="text" placeholder="No Telp" name="noTelp"></li>
                <li><input type="text" placeholder="Kota / Kabupaten" name="kota"></li>
                <li><input type="text" placeholder="Alamat Lengkap" name="alamat"></li>
                <li><input type="password" placeholder="Password" name="password"></li>
                <li><input type="password" placeholder="Re-type Password" name="password2"></li>
                <li><button type="submit" name="registrasi">Daftar</button></li>
            </ul>
        </form>
        <div>
            Ingin menjadi bagian dari kami ?<br/>
            Dafar sebagai agen sekarag !<br/>
            <button><a href="registrasi-agen.php">Registrasi Sebagai Agen</a></button>
        </div>
    </div>
</body>
</html>
