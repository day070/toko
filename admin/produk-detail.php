<?php
require "session.php";
require "../koneksi.php";
$id = $_GET['q'];

$query = mysqli_query($con, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id=b.id WHERE  a. id='$id'");
$data = mysqli_fetch_array($query);

$queryKategori = mysqli_query($con, "SELECT * FROM kategori WHERE id!='$data[kategori_id]'");

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk-Detail</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<style>
    form div {
        margin-bottom: 10px;
    }
</style>

<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-5">
        <h2>Detail Produk</h2>
        <div class="col-12 col-md-6">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="gambarLama" value="<?php $data['foto']; ?>">
                <div>
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" class="form-control" value="<?php echo $data['nama'] ?>"
                        autocomplete="off" required>
                </div>
                <div>
                    <label for="kategori">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control" required>
                        <option value="<?php echo $data['kategori_id']; ?>">
                            <?php echo $data['nama_kategori']; ?>
                        </option>
                        <?php
                        while ($dataKategori = mysqli_fetch_array($queryKategori)) {
                            ?>
                            <option value="<?php echo $dataKategori['id']; ?>">
                                <?php echo $dataKategori['nama']; ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="harga">Harga</label>
                    <input type="number" class="form-control" value="<?php echo $data['harga']; ?>" name="harga"
                        required>
                </div>
                <div>
                    <label for="curent-foto">Foto Produk Sekarang</label><br>
                    <img src="../image/<?php echo $data['foto']; ?>" width="300px">
                </div>
                <div>
                    <label for="foto">Foto</label><br>
                    <input type="file" name="foto" id="foto">
                </div>
                <div>
                    <label for="detail">Detail</label>
                    <textarea name="detail" id="detail" cols="30" rows="10" class="form-control">
                        <?php echo $data['detail'] ?>
                    </textarea>
                </div>
                <div>
                    <label for="stok">Stok</label>
                    <select name="ketersediaan_stok" id="ketersediaan_stok" class="form-control">
                        <option value="<?php echo $data['ketersediaan_stok'] ?>">
                            <?php echo $data['ketersediaan_stok'] ?>
                        </option>
                        <?php
                        if ($data['ketersediaan_stok'] == 'ready') {
                            ?>
                            <option value="kosong">kosong</option>
                            <?php
                        } else {
                            ?>
                            <option value="ready">ready</option>
                            <?php
                        }
                        ?>
                    </select>

                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                    <button type="submit" class="btn btn-danger" name="deleteBtn">Delete</button>
                </div>
            </form>
        </div>
        <?php
        if (isset($_POST['simpan'])) {
            $nama = htmlspecialchars($_POST['nama']);
            $kategori = htmlspecialchars($_POST['kategori']);
            $harga = htmlspecialchars($_POST['harga']);
            $detail = htmlspecialchars($_POST['detail']);
            $ketersediaan_stok = htmlspecialchars($_POST['ketersediaan_stok']);
            if ($_FILES['foto']['error'] == 4) {
                $queryUPDATE = mysqli_query($con, "UPDATE produk SET kategori_id='$kategori', nama='$nama', harga='$harga', detail='$detail', ketersediaan_stok='$ketersediaan_stok' WHERE id=$id ");
                if ($queryUPDATE) {
                    ?>
                    <div class="alert alert-primary mt-3" role="alert">
                        Produk berhasil di Simpan!
                    </div>
                    <meta http-equiv="refresh" content="2; url=produk.php" />
                    <?php
                } else {
                    echo mysqli_error($con);
                }
            } else {
                // Batasan ukuran file (4MB)
                if ($_FILES['foto']['size'] >= 2000000 || $_FILES['foto']['size'] == 0) {
                    ?>
                    <div class="alert alert-danger mt-3" role="alert">
                        Ukuran file gambar melebihi 2MB. Unggahan tidak berhasil.
                    </div>
                    <?php
                } else {
                    $target_dir = "../image/";
                    $nama_file = basename($_FILES["foto"]["name"]);
                    $target_file = $target_dir . $nama_file;
                    $tipe_file = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                    $randomName = generateRandomString(20);
                    $newName = $randomName . "." . $tipe_file;

                    if ($tipe_file != 'jpg' && $tipe_file != 'png' && $tipe_file != 'gif' && $tipe_file != 'jpeg') {
                        ?>
                        <div class="alert alert-danger mt-3" role="alert">
                            Tipe file tidak diperbolehkan. File diluar format 'jpg', 'png', 'gif'.
                        </div>
                        <?php
                    } else {
                        move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $newName);
                        $queryUPDATE = mysqli_query($con, "UPDATE produk SET kategori_id='$kategori', nama='$nama', harga='$harga', detail='$detail', ketersediaan_stok='$ketersediaan_stok', foto='$newName' WHERE id=$id ");
                        if ($queryUPDATE) {
                            ?>
                            <div class="alert alert-primary mt-3" role="alert">
                                Produk berhasil di Simpan!
                            </div>
                            <meta http-equiv="refresh" content="2; url=produk.php" />
                            <?php
                        } else {
                            echo mysqli_error($con);
                        }
                    }
                }
            }
        }
        if (isset($_POST['deleteBtn'])) {
            // Mendapatkan nama file gambar produk
            $queryGetImage = mysqli_query($con, "SELECT foto FROM produk WHERE id='$id'");
            $imageData = mysqli_fetch_array($queryGetImage);
            $imageName = $imageData['foto'];

            // Hapus file gambar dari direktori "image"
            $imagePath = "../image/$imageName";
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            $queryDelete = mysqli_query($con, "DELETE  FROM produk WHERE id='$id'");
            if ($queryDelete) {
                ?>
                Terhapus!
            </div>
            <meta http-equiv="refresh" content="2, url=produk.php" />
            <?php
            }
        }
        ?>
    </div>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
