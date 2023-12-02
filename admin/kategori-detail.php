<?php
require "session.php";
require "../koneksi.php";
$id = $_GET['q'];
$query = mysqli_query($con, "SELECT * FROM kategori WHERE id='$id'");
$data = mysqli_fetch_array($query);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kategori</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>

<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-5">
        <h2>Detail Kategori</h2>
        <div class="col-12 col-md-6">

            <form action="" method="post">
                <div>
                    <label for="kategori">kategori</label>
                    <input type="text" name="kategori" id="kategori" value="<?php echo $data['nama']; ?>"
                        class="form-control">
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary" name="editBtn">Edit</button>
                    <button type="submit" class="btn btn-danger" name="deleteBtn">Hapus</button>
                </div>
            </form>
            <?php
            if (isset($_POST['editBtn'])) {
                $kategori = htmlspecialchars($_POST['kategori']);
                if ($data['nama'] == $kategori) {
                    ?>
                    <meta http-equiv="refresh" content="0; url=kategori.php" />
                    <?php
                } else {
                    $query = mysqli_query($con, "SELECT * FROM kategori WHERE nama='$kategori'");
                    $jumlahData = mysqli_num_rows($query);

                    if ($jumlahData > 0) {
                        ?>
                        <div class="alert alert-danger mt-3" role="alert">
                            Kategori sudah ada!
                        </div>
                        <?php
                    } else {
                        $querySimpan = mysqli_query($con, "UPDATE kategori SET nama='$kategori' WHERE id='$id'");

                        if ($querySimpan) {
                            ?>
                            <div class="alert alert-primary mt-3" role="alert">
                                Berhasil edit kategori!
                            </div>
                            <meta http-equiv="refresh" content="2; url=kategori.php" />
                            <?php

                        } else {
                            echo mysqli_error($con);
                        }
                    }
                }
            }

            if (isset($_POST['deleteBtn'])) {
                $queryCek = mysqli_query($con, "SELECT * FROM  produk WHERE kategori_id='$id'");
                $dataCuy = mysqli_num_rows($queryCek);
                $queryDelete = mysqli_query($con, "DELETE  FROM kategori WHERE id='$id'");
                if ($dataCuy > 0) {
                    ?>

                    <div class="alert alert-danger mt-3" role="alert">
                        Gagal Tejkrhapus Kategori Sedang Digunakan!
                    </div>
                    <?php
                    die();
                }
                if ($queryDelete) {
                    ?>
                    <div class="alert alert-primary mt-3" role="alert">
                        Terhapus!
                    </div>

                    <meta http-equiv="refresh" content="2, url=kategori.php" />
                    <?php
                } else {
                }
            }


            ?>
        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
