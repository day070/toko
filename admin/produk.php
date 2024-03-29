<?php
require "session.php";
require "../koneksi.php";
$query = mysqli_query($con, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id =b.id");
$jumlahProduk = mysqli_num_rows($query);

$queryKategori = mysqli_query($con, "SELECT * FROM kategori");

// functon mengubah nama foto
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
    <title>Produk</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
</head>
<style>
    .no-decoration {
        text-decoration: none;
    }
</style>

<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="../adminpanel" class="no-decoration text-muted"><i class="bi bi-house"></i> Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    produk
                </li>
            </ol>
        </nav>
        <!-- tmabah Produk -->
        <div class="my-5 col-12 col-md-6">
            <h3>tambah produk</h3>
            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" class="form-control" autocomplete="off" required>
                </div>
                <div>
                    <label for="kategori">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        <?php
                        while ($data = mysqli_fetch_array($queryKategori)) {
                            ?>
                            <option value="<?php echo $data['id']; ?>">
                                <?php echo $data['nama']; ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="harga">Harga</label>
                    <input type="number" class="form-control" name="harga" required>
                </div>
                <div>
                    <label for="foto">Foto</label><br>
                    <input type="file" name="foto" id="foto">
                </div>
                <div>
                    <label for="detail">Detail</label>
                    <textarea name="detail" id="detail" cols="30" rows="10" class="form-control"></textarea>
                </div>
                <div>
                    <label for="stok">Stok</label>
                    <select name="ketersediaan_stok" id="ketersediaan_stok" class="form-control">
                        <option value="ready">Tersedia</option>
                        <option value="kosong">Kosong</option>
                    </select>

                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                </div>
            </form>
            <?php
            // Setelah Menekan Button
            if (isset($_POST['simpan'])) {
                $nama = htmlspecialchars($_POST['nama']);
                $kategori = htmlspecialchars($_POST['kategori']);
                $harga = htmlspecialchars($_POST['harga']);
                $detail = htmlspecialchars($_POST['detail']);
                $ketersediaan_stok = htmlspecialchars($_POST['ketersediaan_stok']);

                $target_dir = "../image/";
                $nama_file = basename($_FILES["foto"]["name"]);
                $target_file = $target_dir . $nama_file;
                $tipe_file = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $image_size = $_FILES["foto"]["size"];
                $randomName = generateRandomString(10);
                $newName = $randomName . "." . $tipe_file;

                // pengecekan Kategori
                if ($nama == '' || $kategori == '' || $harga == '') {
                    ?>
                    <div class="alert alert-danger mt-3" role="alert">
                        Nama Kategori dan Harga Wajib ada!
                    </div>
                    <?php
                } else {
                    // pembatasan Size File
                    if ($nama_file != '') {
                        $max_file_size = 2000000; // batas ukuran file dalam byte (50 KB)
            
                        if ($image_size >= $max_file_size || $image_size == 0) {
                            ?>
                            <div class="alert alert-danger mt-3" role="alert">
                                Foto tidak boleh lebih dari 2MB
                            </div>
                            <?php
                            die();
                        } else {
                            if ($tipe_file != 'jpg' && $tipe_file != 'png' && $tipe_file != 'gif' && $tipe_file != 'jpeg') {
                                ?>
                                <div class="alert alert-danger mt-3" role="alert">
                                    Tipe file tidak diperbolehkan
                                </div>
                                <?php
                            } else {
                                move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $newName);

                            }
                        }

                    }
                    // inseert
                    $queryTambah = mysqli_query($con, "INSERT INTO produk (kategori_id, nama, harga, foto, detail, ketersediaan_stok) VALUES('$kategori', '$nama', '$harga', '$newName', '$detail', '$ketersediaan_stok')");
                    if ($queryTambah) {
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
            ?>
        </div>
        <div class="mt-3 mb-5">
            <h2>List Produk</h2>
            <div class="table-responsive mt-5">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($jumlahProduk == 0) {
                            ?>
                            <tr>
                                <td colspan="6" class="text-center">Data Produk tidak tersedia</td>
                            </tr>
                            <?php
                        } else {
                            $jumlah = 1;
                            while ($data = mysqli_fetch_array($query)) {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $jumlah ?>
                                    </td>
                                    <td>
                                        <?php echo $data['nama']; ?>
                                    </td>
                                    <td>
                                        <?php echo $data['nama_kategori']; ?>
                                    </td>
                                    <td>
                                        <?php echo $data['harga']; ?>
                                    </td>
                                    <td>
                                        <?php echo $data['ketersediaan_stok']; ?>
                                    </td>
                                    <td>
                                        <a href="produk-detail.php?q=<?php echo $data['id']; ?>" class="btn btn-info"><i
                                                class="bi bi-search"></i></a>
                                    </td>
                                </tr>
                                <?php
                                $jumlah++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
