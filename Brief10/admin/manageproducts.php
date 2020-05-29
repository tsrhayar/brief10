<?php
session_start();

if (isset($_SESSION['admin'])) {

    $pagetitle = 'Produits';
    $noHeader = '';
    $titleOfPage = 'Gestion des Produits';
    include "init.php"; // include init

    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

    if ($do == 'manage') {

        $stmt = $db->prepare("SELECT * FROM products");
        $stmt->execute(array());

        $rows = $stmt->fetchAll();
?>

        <div class="container">
            <div class="blank"></div>
            <div class="table-responsive table-center text-center">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#ID</th>
                            <th scope="col">Image de produit</th>
                            <th scope="col">Nom de produit</th>
                            <th scope="col">Descripton de produit</th>
                            <th scope="col">Prix de produit</th>
                            <th scope="col">Quantité</th>
                            <th scope="col">Date d<?= '\'' ?>ajoute</th>
                            <th scope="col">Controle</th>
                        </tr>
                    </thead>
                    <?php
                    foreach ($rows as $row) {
                    ?>
                        <tbody>
                            <tr>
                                <th scope="row"><?php echo $row['id'] ?></th>
                                <td><img id="img_product" src="layout/images/<?php echo $row['name'] ?>.png" alt=""></td>
                                <td><?php echo $row['name'] ?></td>
                                <td><?php echo $row['description'] ?></td>
                                <td><?php echo number_format((float) $row['price'], 2, ',', ''); ?> DH</td>
                                <td><?php echo $row['qte'] ?></td>
                                <td><?php echo $row['date'] ?></td>
                                <td>
                                    <a href="?do=edit&id=<?php echo $row['id'] ?>" class="btn btn-success"><i class="fas fa-edit"></i></a>
                                    <a href="?do=delete&id=<?php echo $row['id'] ?>" class="btn btn-danger confirm"><i class="fas fa-trash"></i></a>

                                </td>
                            </tr>
                        </tbody>
                    <?php } ?>
                </table>
            </div>
            <a href="?do=add" class="btn btn-primary"><i class="fas fa-plus"></i>Ajouter produit</a>
        </div>

    <?php

    } elseif ($do == 'add') {
    ?>

        <div class="blank"></div>
        <div class="container">
            <form action="?do=insert" method="POST">
                <input type="hidden" name="userID" value="<?php echo $userid; ?>">
                <div class="form-group">
                    <label for="formGroupExampleInput">Nom de produit</label>
                    <input name="name" type="text" class="form-control" id="UserName" placeholder="Enter le nom de produit" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput">Description de produit</label>
                    <input name="description" type="text" class="form-control" id="UserName" placeholder="Enter la description de produit" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput">prix de produit</label>
                    <input name="price" type="text" class="form-control" id="UserName" placeholder="Enter le prix de produit" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput">Quantité</label>
                    <input name="qte" type="number" class="form-control" id="UserName" placeholder="Enter le prix de produit" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <input type="submit" value="Ajouter le produit" class="btn btn-primary">
                </div>
            </form>
        </div>

        <?php

    } elseif ($do == 'insert') {
        echo '<h1 class="text-center">Ajouter un produit</h1>';
        echo '<div class="blank"></div>';

        $name           = $_POST['name'];
        $description    = $_POST['description'];
        $price          = $_POST['price'];
        $qte            = $_POST['qte'];

        if ((checkIfExists("name", "products", $name)) === 0) {
            $stmt = $db->prepare("INSERT INTO products ( name, description, price, qte, date) VALUES (?, ?, ?, ?, now())");
            $stmt->execute(array($name, $description, $price, $qte));
            $nombreModif = $stmt->rowCount();

            header("location: manageproducts.php");

            // echo '<div class="alert alert-success" role="alert">' .  $nombreModif . " produit ajouté" . '</div>';
            // echo '<div class="container text-center">';
            // echo '<a class="btn btn-primary text-center" href="http://localhost/Brief10/admin/manageproducts.php">RETOUR</a>';
            // echo '</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Le nom de ce produit est déjà exist</div>';
            echo '<div class="container text-center">';
            echo '<a class="btn btn-primary text-center" href="http://localhost/Brief10/admin/manageproducts.php">RETOUR</a>';
            echo '</div>';
        }
    } elseif ($do == 'edit') { // edit page 
        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;

        $stmt = $db->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
        $stmt->execute(array($id));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

        if ($count > 0) {

        ?>

            <div class="blank"></div>
            <div class="container">
                <form action="?do=update" method="POST">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="form-group">
                        <label for="formGroupExampleInput">Le nom de produit</label>
                        <input name="name" type="text" class="form-control" id="UserName" value="<?php echo $row['name'] ?>" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="formGroupExampleInput">La description de produit</label>
                        <input name="description" type="text" class="form-control" id="UserName" value="<?php echo $row['description'] ?>" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="formGroupExampleInput">Le prix de produit</label>
                        <input name="price" type="text" class="form-control" id="UserName" value="<?php echo $row['price'] ?>" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="formGroupExampleInput">Quantité</label>
                        <input name="qte" type="number" class="form-control" id="UserName" value="<?php echo $row['qte'] ?>" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="formGroupExampleInput">Ajouter QTE</label>
                        <input name="addqte" type="number" class="form-control" id="UserName" value="0" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Save" class="btn btn-primary">
                    </div>
                </form>
            </div>
<?php
        } else {
            $errorMsg = 'Tu peut pas entrer directement dans cette page';
            redirect($errorMsg, 5);
        }
    } elseif ($do == 'update') {


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {


            echo '<div class="blank"></div>';

            $id             = $_POST['id'];
            $name           = $_POST['name'];
            $description    = $_POST['description'];
            $price          = $_POST['price'];
            $addqte         = $_POST['addqte'];
            $qte            = ($_POST['qte']) + $addqte;



            $stmt = $db->prepare("UPDATE products SET name=? , description =? , price=?,qte=? WHERE id=?");
            $stmt->execute(array($name, $description, $price, $qte, $id));
            $nombreModif = $stmt->rowCount();

            echo '<div class="alert alert-success" role="alert">Modification faite avec succes , nombre des modifications est: ' .  $nombreModif . '</div>';
            echo '<div class="container text-center">';
            echo '<a class="btn btn-primary text-center" href="http://localhost/Brief10/admin/manageproducts.php">RETOUR</a>';
            echo '</div>';
        }
    } elseif ($do == 'delete') {
        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;

        $countID = checkIfExists("id", "products", $id);

        if ($countID > 0) {
            $stmt = $db->prepare("DELETE FROM products WHERE id = ?");
            $stmt->execute(array($id));
            $count = $stmt->rowCount();
            // echo '<h1 class="text-center">Lasu</h1>';
            echo '<div class="blank"></div>';
            echo '<div class="alert alert-success" role="alert">La supression est faite avec succes , ' .  $count . ' éléments suprimmé' . '</div>';
            echo '<div class="container text-center">';
            echo '<a class="btn btn-primary" href="http://localhost/Brief10/admin/manageproducts.php">RETOUR</a>';
            echo '</div>';
        } else {
            $errorMsg = 'Y\'a pas un membre avec ce ID';

            redirect($errorMsg, 5, "members");
        }
    }
    include $tplDirName . "footer.php";
} else {
    header('location: index.php');
}
