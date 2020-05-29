<?php
session_start();

if (isset($_SESSION['admin']) || isset($_SESSION['user'])) {
    $pagetitle = 'Dashbord';
    include "init.php"; // include init 



?>
    <div class="container text-center">
        <?php
        $titleOfPage = "Bienvenu sur notre site web";
        include "includes/templates/titleOfPage.php"
        ?>
        <div class="blank"></div>
        <a href="products.php" class="btn btn-success">Voir Notre Produits</a>
    </div>

<?php
    include $tplDirName . "footer.php";
} elseif (isset($_SESSION['admin'])) {

    header('location: products.php');
}else {
    header('location: index.php');
}
