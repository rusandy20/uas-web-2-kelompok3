<?php 
 
session_start();
 
if (!isset($_SESSION['username'])) {
    header("Location: we.php");
}
 
?>
 <?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "uaskelompok3";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
$jumlah_transaksi= "";
$jumlah_dana             = "";
$alokasi                = "";
$sukses                 = "";
$error                   = "";
$id ="";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $id         = $_GET['id'];
    $sql1       = "delete from  rekapitulasi where id = '$id'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $id         = $_GET['id'];
    $sql1       = "select * from  rekapitulasi where id = '$id'";
    $q1         = mysqli_query($koneksi, $sql1);
    $r1         = mysqli_fetch_array($q1);
    $alokasi                 = $r1['alokasi'];
    $jumlah_transaksi       = $r1['jumlah_transaksi'];
    $jumlah_dana              = $r1['jumlah_dana'];

    if ($alokasi == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { //untuk create
    $id = $_POST['id'];
    $alokasi             = $_POST['alokasi'];
    $jumlah_transaksi     = $_POST['jumlah_transaksi'];
    $jumlah_dana          = $_POST['jumlah_dana'];

    if ($alokasi && $jumlah_transaksi && $jumlah_dana ) {
        if ($op == 'edit') { //untuk update
            $sql1       = "update  rekapitulasi set alokasi ='$alokasi',jumlah_transaksi='$jumlah_transaksi',jumlah_dana='$jumlah_dana' where id = '$id'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1   = "insert into rekapitulasi (id,alokasi,jumlah_transaksi,jumlah_dana) values ('id','$alokasi','$jumlah_transaksi','$jumlah_dana')";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses     = "Berhasil memasukkan data baru";
            } else {
                $error      = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silakan masukkan semua data";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uas kelompok 3</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>
        <!-- untuk mengeluarkan data -->
        <div class="card">
            <div class="card-body">
            <div align= center class="card-header text-white bg-secondary">
                Rekapitulasi Penerimaan Bantuan Sosial COVID-19<br>
                Sampai dengan ,<?php echo date('d F Y, h:i:s A'); ?>
            </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">alokasi</th>
                            <th scope="col">jumlah transaksi</th>
                            <th scope="col">jumlah dana</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select * from rekapitulasi order by id desc";
                        $q2     = mysqli_query($koneksi, $sql2);
                        $urut   = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id         = $r2['id'];
                            $alokasi        = $r2['alokasi'];
                            $jumlahtransaksi       = $r2['jumlah_transaksi'];
                            $jumlahdana     = $r2['jumlah_dana'];
                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $alokasi ?></td>
                                <td scope="row"><?php echo $jumlahtransaksi ?></td>
                                <td scope="row"><?php echo $jumlahdana ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>
</body>
	<script>
		window.print();
	</script>

</body>
</html>