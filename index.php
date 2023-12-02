<?php
require("koneksi.php");
$queryProduk = mysqli_query($con, "SELECT id, nama, harga, foto, detail FROM produk LIMIT 6");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online | Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php require("navbar.php") ?>
    <!-- Banner -->
    <div class="contaier-fluid banner d-flex align-items-center">
        <div class="container text-center text-white">
            <h1>Toko Online Tecknologi</h1>
            <h3>Mau Cari APA?</h3>
            <div class="col-md-8 offset-md-2">
                <form action="produk.php" method="get">
                    <div class="input-group input-group-lg my-4 mb-3">
                        <input type="text" class="form-control" placeholder="Nama Barang..." name="keyword">
                        <button type="submit" class="btn warna2 text-white">Telusuri</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- kategori -->
    <div class="container-fluid py-5">
        <div class="container text-center">
            <h3>Anjay</h3>

            <div class="row mt-5">
                <div class="col-md-4 col-sm-6 mb-4">
                    <div
                        class="highlighted-kategori highlighted-kategori-keyboard d-flex justify-content-center align-items-center">
                        <a href="produk.php?kategori=Keyboard" class="no-decoration">
                            <h4 class="text-white">Keyboard</h4>
                        </a>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div
                        class="highlighted-kategori highlighted-kategori-laptop d-flex justify-content-center align-items-center">
                        <a href="produk.php?kategori=Laptop" class="no-decoration">
                            <h4 class="text-white">Laptop</h4>
                        </a>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div
                        class="highlighted-kategori highlighted-kategori-mouse d-flex justify-content-center align-items-center">
                        <a href="produk.php?kategori=Mouse" class="no-decoration">
                            <h4 class="text-white">Mouse</h4>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tentang Kami -->
    <div class="container-fluid warna3 py-5">
        <div class="container text-center">
            <h3>Tentang Kami</h3>
            <p class="fs-5 mt-3">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Dignissimos, quas. Similique
                mollitia dolore,
                facilis voluptatum ipsa ea fugit in unde officiis minus sunt, nam quibusdam repudiandae sit distinctio
                minima accusantium! Tenetur consequuntur, doloremque asperiores nesciunt delectus perferendis
                recusandae! Ipsam, quis! Quibusdam velit, consequatur magni inventore tempore facere dolorum. Maiores
                iste quis debitis consequatur nemo, aliquid recusandae sed, corporis quam neque commodi tenetur facilis
                quibusdam eligendi ipsum corrupti inventore nisi eius vitae blanditiis! Impedit sed minima aut modi
                nesciunt architecto saepe?</p>
        </div>
    </div>

    <!-- Produk -->
    <div class="container-fluid py-5">
        <div class="container text-center">
            <h3>Produk</h3>
            <div class="row mt-5">
                <?php while ($dataProduk = mysqli_fetch_array($queryProduk)) { ?>
                    <div class="col-sm-6 col-md-4 mb-3">
                        <div class="card">
                            <img src="image/<?php echo $dataProduk['foto'] ?>" class="card-img-top">
                            <div class="card-body">
                                <h4 class="card-title">
                                    <?php echo $dataProduk['nama'] ?>
                                </h4>
                                <p class="card-text text-truncate">
                                    <?php echo $dataProduk['detail'] ?>
                                </p>
                                <p class="card-text text-harga">Rp
                                    <?php echo $dataProduk['harga'] ?>
                                </p>
                                <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </div>
                    <?php
                    $dataProduk++;
                } ?>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>