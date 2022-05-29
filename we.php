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
<body>
    <div class="mx-auto">
    <nav class="navbar navbar-expand-lg bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="we.php">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="we.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cetak.php">cetak</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
        <!-- untuk memasukkan data -->
        <div class="card">
            <div class="card-header">
                Create / Edit Data
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:5;url=we.php");//5 : detik
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:5;url=we.php");
                }
                ?>
                <form action="" method="POST">
                <div class="mb-3 row">
                        <label for="id" class="col-sm-2 col-form-label">id</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="id" name="id" value="<?php echo $id ?>">
                        </div>
                    </div>
                <div class="mb-3 row">
                        <label for="alokasi" class="col-sm-2 col-form-label">Alokasi</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="alokasi" id="alokasi">
                                <option value="">- Pilih Alokasi -</option>
                                <option value="alat pelindung diri" <?php if ($alokasi == "alat pelindung diri") echo "selected" ?>>alat pelindung diri</option>
                                <option value="logistik mahasiswa" <?php if ($alokasi == "logistik mahasiswa") echo "selected" ?>>logistik mahasiswa</option>
                                <option value="bantuan kuota mahasiswa" <?php if ($alokasi == "bantuan kuota mahasiswa") echo "selected" ?>>bantuan kuota mahasiswa</option>
                                <option value="Hand sanitirzer" <?php if ($alokasi == "Hand sanitirzer") echo "selected" ?>>Hand sanitirzer</option>
                                <option value="saintek" <?php if ($alokasi == "sembako masyarakat") echo "selected" ?>>sembako masyarakat</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="jumlah_transaksi" class="col-sm-2 col-form-label">Jumlah Transaksi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="jumlah_transaksi" name="jumlah_transaksi" value="<?php echo $jumlah_transaksi ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="jumlah_dana" class="col-sm-2 col-form-label">Jumlah Dana</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="jumlah_dana" name="jumlah_dana" value="<?php echo $jumlah_dana ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>

        <!-- untuk mengeluarkan data -->
        <div class="card">
            <div class="card-header text-white bg-secondary" align=center>
                Rekapitulasi Penerimaan Bantuan Sosial COVID-19<br>
            Sampai dengan ,<?php echo date('d F Y, h:i:s A'); ?>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">alokasi</th>
                            <th scope="col">jumlah transaksi</th>
                            <th scope="col">jumlah dana</th>
                            <th scope="col">Aksi</th>
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
                                <td scope="row">
                                    <a href="we.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="we.php?op=delete&id=<?php echo $id?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>            
                                </td>
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