<?php include "z_db.php"; ?>
<?php include "header.php"; ?>

<!-- ***** Breadcrumb Area Start ***** -->
<section class="section breadcrumb-area overlay-dark d-flex align-items-center">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-content d-flex flex-column align-items-center text-center">
                    <h2 class="text-white text-uppercase mb-3">Ürünler</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-uppercase text-white" href="home">Ana Sayfa</a></li>
                        <li class="breadcrumb-item text-white active">Ürünler</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ***** Breadcrumb Area End ***** -->

<!--====== Products Area Start ======-->
<section class="section products-area ptb_100">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <!-- Kategoriler ve Alt Kategoriler -->
                <div class="category-list">
                    <h4>Kategoriler</h4>
                    <ul class="list-group">
                        <?php
                        // Kategorileri çek
                        $categories_query = mysqli_query($con, "SELECT * FROM kategoriler");
                        while ($category = mysqli_fetch_array($categories_query)) {
                            ?>
                            <li class="list-group-item">
                                <a href="#" class="category-toggle" data-category-id="<?php echo $category['id']; ?>"><?php echo $category['isim']; ?></a>
                                <ul class="list-group subcategory-list" id="subcategory-<?php echo $category['id']; ?>" style="display: none;">
                                    <?php
                                    // Alt kategorileri al
                                    $subcategories_query = mysqli_query($con, "SELECT * FROM alt_kategoriler WHERE kategori_id = " . $category['id']);
                                    while ($subcategory = mysqli_fetch_array($subcategories_query)) {
                                        ?>
                                        <li class="list-group-item">
                                            <a href="?alt_kategori_id=<?php echo $subcategory['id']; ?>"><?php echo $subcategory['isim']; ?></a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="row">
                    <?php
                    // Filtreleme mantığı
                    if (isset($_GET['alt_kategori_id'])) {
                        $product_query = mysqli_query($con, "SELECT * FROM urunler WHERE alt_kategori_id = " . $_GET['alt_kategori_id']);
                    } elseif (isset($_GET['kategori_id'])) {
                        $subcategory_query = mysqli_query($con, "SELECT * FROM alt_kategoriler WHERE kategori_id = " . $_GET['kategori_id']);
                        $subcategory_ids = [];
                        while ($subcategory = mysqli_fetch_array($subcategory_query)) {
                            $subcategory_ids[] = $subcategory['id'];
                        }
                        $ids = implode(',', $subcategory_ids);
                        $product_query = mysqli_query($con, "SELECT * FROM urunler WHERE alt_kategori_id IN ($ids)");
                    } else {
                        $product_query = mysqli_query($con, "SELECT * FROM urunler");
                    }

                    while ($product = mysqli_fetch_array($product_query)) {
                        ?>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 mb-4">
                            <div class="card">
                                <img src="<?php echo $product['resim']; ?>" class="card-img-top"?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $product['isim']; ?></h5>
                                    <p class="card-text"><?php echo $product['aciklama']; ?></p>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!--====== Products Area End ======-->

<?php include "footer.php"; ?>
