<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>form bca finance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px;
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>
<body>

<?php
    include("koneksi.php");
    $id = "";
    $nama = "";
    $nominal = "";
    $jenis = "";
    $sukses = "";
    $error = "";
    $op="";

    $jumlah=0;
   
    if (isset($_GET['op'])) {
        $op = $_GET['op'];
    } else {
        $op = "";
    }
    if($op == 'delete'){
        $idk = $_GET['idk'];
        $id = $_GET['id'];
        $q15 = mysqli_query($koneksi, "update saldo,transaksi set saldo = saldo - transaksi.nominal where saldo.id='$id' and transaksi.idk='$idk' ");
        $q6 =mysqli_query($koneksi,"delete from transaksi where idk = '$idk'");
        
        header("refresh:5;url=index.php");
        
    }

    if ($op == 'edit') {
        $idk = $_GET['idk'];
        $id = $_GET['id'];
       
        $sql9       = "select * from transaksi where idk ='$idk'";
        $q9         = mysqli_query($koneksi, $sql9);
        $r9         = mysqli_fetch_array($q9);
        $sql10       = "select * from saldo where id ='$id'";
        $q10         = mysqli_query($koneksi, $sql10);
        $r10         = mysqli_fetch_array($q10);
        $id        = $r9['id'];
        $jenis       = $r9['jenis'];
        $nominal     = $r9['nominal'];
        $tanggal = $r9['tanggal'];
        $saldo = $r10['saldo'];

    }

    if (isset($_POST['simpan'])) {  //untuk create
        $id = $_POST['id'];
        $tanggal = $_POST['tanggal'];
        $nominal = $_POST['nominal'];
        $jenis = $_POST['jenis'];

        

        if ($id && $tanggal && $nominal && $jenis) {
            if ($op == 'edit') { 
                $q20 = mysqli_query($koneksi, "update saldo,transaksi set saldo = saldo - transaksi.nominal where saldo.id='$id' and transaksi.idk='$idk' ");
               //untuk update
                $sql5       = "update transaksi set id ='$id',nominal='$nominal',jenis='$jenis',tanggal='$tanggal' where id = '$id'";
                $q5         = mysqli_query($koneksi, $sql5);
                $q233 = mysqli_query($koneksi, "update saldo,transaksi set saldo = saldo + transaksi.nominal where saldo.id='$id' and transaksi.id='$id' ");
                if ($q5 && $q20) {
                    $sukses  = "Data berhasil diupdate";
                } else {
                    $error = "Data gagal diupdate";
                }
            } else { //untuk insert
                $sql1 = "insert into transaksi (id,tanggal,nominal,jenis) values ('$id','$tanggal','$nominal','$jenis')";
                $q1 = mysqli_query($koneksi, $sql1);
                $sql14 = "update saldo,transaksi set saldo = saldo + transaksi.nominal where saldo.id='$id' and transaksi.id='$id' ";
                $q14 = mysqli_query($koneksi, $sql14);
                
                if ($q1 && $q14) {
                    $sukses  = "Data berhasil dimasukkan";
                } else {
                    $error = "Data gagal dimasukkan";
                }
            }
        } else {
            $error = "Silahkan masukkan semua data";
        }
    
    }


    ?>
<div class="mx-auto">
        <div class="card">
            <div class="card-header">
                Create / Edit Data BCA Finance
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:15;url=index.php");
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
               header("refresh:15;url=index.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="id" class="col-sm-2 col-form-label">ID</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="id" name="id" value="<?php echo $id ?>">
                        </div>
                    </div>
                    
                    <div class="mb-3 row">
                        <label for="nominal" class="col-sm-2 col-form-label">Nominal</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="nominal" name="nominal" value="<?php echo $nominal ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="jenis" class="col-sm-2 col-form-label">Jenis</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="jenis" name="jenis">
                                <option value="">-Pilih Jenis-</option>
                                <option value="Debet" <?php if ($jenis == "Debet") echo "selected" ?>>Debet</option>
                                <option value="Kredit" <?php if ($jenis == "Kredit") echo "selected" ?>>Kredit</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="tanggal" class="col-sm-2 col-form-label">Tanggal</label>
                        <div class="col-sm-10">
                            <input type="datetime-local" class="form-control" id="tanggal" name="tanggal" value="<?php echo $tanggal ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan" class="btn btn-primary">
                    </div>

                </form>
            </div>
        </div>


        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data Transaksi
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">ID</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Nominal</th>
                            <th scope="col">saldo</th>
                            <th scope="col">Jenis</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    <tbody>
                        <?php
                        $sql2 = "select a.nama,a.id, a.saldo, b.jenis,b.idk, b.nominal, b.tanggal, b.jenis from saldo as a inner join transaksi as b on a.id = b.id";
                        $q2 = mysqli_query($koneksi, $sql2);
                        $urut = 1;
            
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $idk         = $r2['idk'];
                            $id         = $r2['id'];
                            $nama = $r2['nama'];
                            $nominal       = $r2['nominal'];
                            $jenis     = $r2['jenis'];
                            $saldo = $r2['saldo'];
                            $tanggal     = $r2['tanggal'];
                           
                
                        

                          
                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $tanggal ?></td>
                                <td scope="row"><?php echo $id ?></td>
                                <td scope="row"><?php echo $nama ?></td>
                                <td scope="row"><?php echo $nominal ?></td>
                                <td scope="row"><?php echo $saldo ?></td>
                                <td scope="row"><?php echo $jenis ?></td>
                                <td scope="row">
                                    <a href="index.php?op=edit&idk=<?php echo $idk?>&id=<?php echo $id?>"><button type=" button" class="btn btn-warning">Edit</button></a>
                                    <a href="index.php?op=delete&idk=<?php echo $idk?>&id=<?php echo $id?>" onclick="return confirm('Yakin Mau Delete Data?')"> <button type="button" class="btn btn-danger">Delete</button> </a>
                                    
                                </td>
                            </tr>
                        <?php
                        }

                        ?>
                    </tbody>
                    </thead>
                </table>

            </div>
        </div>

    </div>


    
</body>
</html>