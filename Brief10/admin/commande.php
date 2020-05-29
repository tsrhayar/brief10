<?php
session_start();

if (isset($_SESSION['admin']) || isset($_SESSION['user'])) {

    $pagetitle = 'Commande';
    $noHeader = '';
    $titleOfPage = 'Resérvation';
    include "init.php"; // include init   

?>
    <div class="blank"></div>

    <?php

    $do = isset($_GET['do']) ? $_GET['do'] : 'welcome';

    $stmt = $db->prepare("SELECT * FROM products");
    $stmt->execute(array());

    $rows = $stmt->fetchAll();

    if ($do == 'welcome') {

    ?>
        <div class="blank"></div>
        <div class="container">
            <form action="?do=update" method="POST">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div class="form-group">
                    <!-- <label for="exampleFormControlSelect1">Example select</label> -->
                    <select name="commandeProduct" class="form-control" id="exampleFormControlSelect1" required>
                        <option value=""> -- selectionner le produit -- </option>

                        <?php
                        foreach ($rows as $row) {
                        ?>
                            <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput">Quantité</label>
                    <input name="choiceQte" type="number" class="form-control" value="1" min="1" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <input type="submit" value="Passer la commande" class="btn btn-primary">
                </div>
            </form>
        </div>



        <?php
    } elseif ($do == "commande") {
        $id         = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        $countID    = checkIfExists("id", "products", $id);

        $stmt       = $db->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
        $stmt->execute(array($id));
        $row        = $stmt->fetch();

        if ($countID > 0) {
        ?>
            <div class="blank"></div>
            <div class="container">
                <form action="?do=update" method="POST">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="form-group">
                        <label for="formGroupExampleInput">Nom de Produit</label>
                        <input type="hidden" name="commandeProduct" value="<?php echo $row['id'] ?>">
                        <input name="nameProduct" type="text" class="form-control" value="<?php echo $row['name'] ?>" disabled="disabled">
                    </div>
                    <div class="form-group">
                        <label for="formGroupExampleInput">Quantité</label>
                        <input name="choiceQte" type="number" class="form-control" value="1" min="1" max="<?php echo $row['qte'] ?>" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Passer la commande" class="btn btn-primary">
                    </div>
                </form>
            </div>
<?php
        }
    } elseif ($do == 'update') {
        ////echo $_POST['commandeProduct'] . "<br>";
        ////echo $_POST['choiceQte'] . "<br>";

        $commandeProduct    = $_POST['commandeProduct'];
        $choiceQte          = $_POST['choiceQte'];

        $stmt   = $db->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
        $stmt->execute(array($commandeProduct));
        $row    = $stmt->fetch();
        $count  = $stmt->rowCount();
        $qte    = $row['qte'];
        $newQte = $qte - $choiceQte;

        if ($count > 0) {

            $stmt = $db->prepare("UPDATE products SET qte=? WHERE id=?");
            $stmt->execute(array($newQte, $commandeProduct));
            $nombreModif = $stmt->rowCount();
            if ($nombreModif > 0) {
                echo '<div class="blank"></div>';
                echo '<div class="alert alert-success text-center" role="alert">La commande est faite avec succés <br>'. '<b>' . $row['name'] . '</b>' .'<b>, Qte: ' .  $choiceQte . '.</b>' . '</div>';
                echo '<div class="container text-center">';
                echo '<a class="btn btn-primary" href="http://localhost/Brief10/admin/products.php">RETOUR</a>';
                echo '</div>';
            }
        }
    }
    //elseif ($do == 'add') {

    // } elseif ($do == 'insert') {

    // } elseif ($do == 'edit') {// edit page 

    // }


    // elseif ($do == 'delete') {

    // }
    include $tplDirName . "footer.php";
} else {
    header('location: index.php');
}
