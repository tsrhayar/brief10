<?php
session_start();

if (isset($_SESSION['admin']) || isset($_SESSION['user'])) {

    $pagetitle = 'products';
    $noHeader = '';
    $titleOfPage = 'Les Produits';
    include "init.php"; // include init

?>
    <div class="blank"></div>
    <?php

    $do = isset($_GET['do']) ? $_GET['do'] : 'welcome';

    if ($do == 'welcome') {

        $stmt = $db->prepare("SELECT * FROM products WHERE qte > 0 ");
        $stmt->execute(array());

        $rows = $stmt->fetchAll();

    ?>

        <div class="container product-container">
            <?php foreach ($rows as $row) {
            ?>
                <div class="product-parent-div">
                    <div class="product-childs-div">
                        <div class="img-product"><img src="layout/images/<?php echo $row['name'] ?>.png" alt=""></div>
                        <div class="info-product">
                            <h2 id="name"><?php echo $row['name'] ?></h2>
                            <h2 id="price"> <?php echo number_format((float) $row['price'], 2, ',', '');   ?> DH</h2>
                            <h4 id="desc"><?php echo $row['description'] ?></h4>
                            <h3 id="qte">Qte en stock: <?php echo $row['qte'] ?></h3>
                        </div>
                        <div class="commande-product">
                            <a href="commande.php?do=commande&id=<?php echo $row['id'] ?>" class="btn btn-info">Acheter</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

<?php

    }
    //// elseif ($do == 'add') {
    // //} elseif ($do == 'insert') {
    // //} elseif ($do == 'edit') { // edit page 
    // //} elseif ($do == 'update') {
    // //} elseif ($do == 'delete') {
    // //}
    include $tplDirName . "footer.php";
} else {
    header('location: index.php');
}
