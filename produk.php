<?php
require("koneksi.php");
$queryKategori = mysqli_query($con, "SELECT * FROM kategori");

//get produk keyword
if (isset($_GET['keyword'])) {
    $nama = $_GET['keyword'];
    $queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE nama LIKE '%$nama%'");
}
//get produk kategori
else if (isset($_GET['kategori'])) {
    $queryGetKategoriId = mysqli_query($con, "SELECT id FROM kategori WHERE nama ='$_GET[kategori]' ");
    $kategoriId = mysqli_fetch_array($queryGetKategoriId);
    $queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE kategori_id = '$kategoriId[id]' ");

}

//get produk defaut
else {
    $queryProduk = mysqli_query($con, "SELECT * FROM produk");

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online | Produk</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php require("navbar.php") ?>
    <!-- Banner -->
    <div class="container-fluid banner-produk d-flex align-items-center">
        <div class="container">
            <h1 class="text-white text-center">Produk</h1>
        </div>
    </div>

    <!-- Body -->
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-3 mb-5">
                <h3>Kategori</h3>
                <ul class="list-group">

                    <a href="produk.php" class="no-decoration">
                        <li class="list-group-item">
                            All
                        </li>
                    </a>
                    <?php while ($kategori = mysqli_fetch_array($queryKategori)) { ?>
                        <a href="produk.php?kategori=<?php echo $kategori['nama'] ?>" class="no-decoration">
                            <li class="list-group-item">
                                <?php echo $kategori['nama'] ?>
                            </li>
                        </a>
                    <?php } ?>
                </ul>
            </div>
            <div class="col-lg-9">
                <h3 class="mb-3 text-center">Produk</h3>
                <div class="row">
                    <?php while ($produk = mysqli_fetch_array($queryProduk)) { ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="image-box">
                                    <img src="image/<?php echo $produk['foto'] ?>" class="card-img-top">
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title">
                                        <?php echo $produk['nama'] ?>
                                    </h4>
                                    <p class="card-text text-truncate">
                                        <?php echo $produk['detail'] ?>
                                    </p>
                                    <p class="card-text text-harga">Rp
                                        <?php echo $produk['harga'] ?>
                                    </p>
                                    <a href="produk-detail.php?nama=<?php echo $dataProduk['nama'] ?>"
                                        class="btn warna2 text-white">Lihat
                                        detail</a>
                                </div>
                            </div>
                        </div>
                        <?php
                        $produk++;
                    } ?>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>