<?php
require("koneksi.php");
$nama = htmlspecialchars($_GET['nama']);
$queryproduk = mysqli_query($con, "SELECT * FROM produk WHERE nama = '$nama'");
$produk = mysqli_fetch_array($queryproduk);
$foto = $produk['foto'];
$nama = $produk['nama'];
$detail = $produk['detail'];
$harga = $produk['harga'];
$stok = $produk['ketersediaan_stok'];

$queryProdukTerkait = mysqli_query($con, "SELECT * FROM produk WHERE kategori_id = '$produk[kategori_id]' AND id != '$produk[id]'");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online | Produk Detail</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include("navbar.php") ?>
    <!-- Detail Produk -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 mb-3">
                    <img src="image/<?php echo $foto ?>" class="w-100" alt="">
                </div>
                <div class="col-lg-6 offset-lg-1">
                    <h1>
                        <?php echo $nama ?>
                    </h1>
                    <p class="fs-5">
                        <?php echo $detail ?>
                    </p>
                    <p class="text-harga">Rp.
                        <?php echo $harga ?>
                    </p>
                    <p class="fs-5">
                        Status Ketersediaan : <strong>
                            <?php echo $stok ?>
                        </strong>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- Produk Terkait -->
    <div class="container-fluid py-3 warna1">
        <div class="container">
            <h2 class="text-center text-white mb-5">Produk Terkait</h2>
            <div class="row">
                <?php while ($produkT = mysqli_fetch_array($queryProdukTerkait)) { ?>
                    <div class="col-md-6 col-lg-3">
                        <a href="produk-detail.php?nama=<?php echo $produkT['nama'] ?>">
                            <img src="image/<?php echo $produkT['foto'] ?>"
                                class="img-fluid img-thumbnail mb-3 produk-terkait-image" alt="">
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>

    </div>
    <?php include("footer.php") ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>