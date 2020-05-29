<?php
session_start();

if (isset($_SESSION['admin'])) {
    $pagetitle = 'Produits';
    include "init.php"; // include init

    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

    if ($do == 'manage') {

        $stmt = $db->prepare("SELECT * FROM users WHERE groupeID != 1");
        $stmt->execute(array());

        $rows = $stmt->fetchAll();
?>

        <div class="container">
            <h1 class="text-center">ADD Les Membres</h1>
            <div class="blank"></div>
            <div class="table-responsive table-center text-center">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#ID</th>
                            <th scope="col">UserName</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">FullName</th>
                            <th scope="col">Date Register</th>
                            <th scope="col">Controle</th>
                        </tr>
                    </thead>
                    <?php
                    foreach ($rows as $row) {
                    ?>
                        <tbody>
                            <tr>
                                <th scope="row"><?php echo $row['userID'] ?></th>
                                <td><?php echo $row['username'] ?></td>
                                <td><?php echo $row['email'] ?></td>
                                <td><?php echo $row['fullname'] ?></td>
                                <td> <?php echo $row['dateRegistre'] ?> </td>
                                <td>
                                    <a href="?do=edit&userID=<?php echo $row['userID'] ?>" class="btn btn-success" title="modifier"><i class="fas fa-edit"></i></a>
                                    <a href="?do=delete&userID=<?php echo $row['userID'] ?>" class="btn btn-danger confirm" title="supprimer"><i class="fas fa-trash"></i></a>
                                    <?php
                                    if ($row['regStatus'] == 0) {
                                    ?>
                                        <a href="?do=activate&userID=<?php echo $row['userID'] ?>" class="btn btn-info" title="confirmer"><i class="fas fa-check"></i></a>
                                    <?php } ?>
                                </td>
                            </tr>
                        </tbody>
                        <?php } ?>
                </table>
            </div>
            <a href="?do=add" class="btn btn-primary"><i class="fas fa-plus"></i> Add page</a>
        </div>

    <?php
    } elseif ($do == 'add') {

        // $userid = $_SESSION['admin'];

        // $stmt = $db->prepare("SELECT * FROM users WHERE userID = ? LIMIT 1");
        // $stmt->execute(array($userid));
        // $row = $stmt->fetch();
        // $count = $stmt->rowCount();
    ?>

        <h1 class="text-center">ADD Les Membres</h1>
        <div class="blank"></div>
        <div class="container">
            <form action="?do=insert" method="POST">
                <input type="hidden" name="userID" value="<?php echo $userid; ?>">
                <div class="form-group">
                    <label for="formGroupExampleInput">UserName</label>
                    <input name="username" type="text" class="form-control" id="UserName" placeholder="UserName" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput2">Password</label>
                    <input name="password" type="password" class="form-control" id="formGroupExampleInput2" autocomplete="off" placeholder="Si vous pas voulez changer le mot de pass laisse ce champ vide">
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput3">Email</label>
                    <input name="email" type="email" class="form-control" id="formGroupExampleInput3" autocomplete="off" placeholder="Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput4">Fullname</label>
                    <input name="fullname" type="text" class="form-control" id="formGroupExampleInput4" autocomplete="off" placeholder="Fullname">
                </div>
                <div class="form-group">
                    <input type="submit" value="Ajouter" class="btn btn-primary">
                </div>
            </form>
        </div>

        <?php } elseif ($do == 'insert') {

        // echo $_POST['username'] . " " . $_POST['password'] . " " . $_POST['email'] . " " . $_POST['fullname'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            echo '<h1 class="text-center">ADD Les Membres</h1>';
            echo '<div class="blank"></div>';

            $username   = $_POST['username'];
            $password   = $_POST['password'];
            $email      = $_POST['email'];
            $fullname   = $_POST['fullname'];
            $hashedpass = sha1($password);

            $errorMsg = array();

            if ((checkIfExists("username", "users", $username)) === 0) {
                $stmt = $db->prepare("INSERT INTO `users` ( username, password, email, fullname, dateRegistre) VALUES (?, ?, ?, ?, now())");
                $stmt->execute(array($username, $hashedpass, $email, $fullname));
                $nombreModif = $stmt->rowCount();

                echo '<div class="alert alert-success" role="alert">L\'ajoute faite avec succes , nombre des ajoutes est: ' .  $nombreModif . '</div>';
                echo '<div class="container text-center">';
                echo '<a class="btn btn-primary text-center" href="http://localhost/Brief10/admin/members.php">RETOUR</a>';
                echo '</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Ce nom d\'utilisateur deja exists</div>';
                echo '<div class="container text-center">';
                echo '<a class="btn btn-primary text-center" href="http://localhost/Brief10/admin/members.php">RETOUR</a>';
                echo '</div>';
            }
        } else {

            $errorMsg = 'Tu peut pas entrer directement dans cette page';

            redirect($errorMsg, 5);
        }
    } elseif ($do == 'edit') { // edit page 

        $userid = isset($_GET['userID']) && is_numeric($_GET['userID']) ? intval($_GET['userID']) : 0;

        $stmt = $db->prepare("SELECT * FROM users WHERE userID = ? LIMIT 1");
        $stmt->execute(array($userid));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

        if ($count > 0) {

        ?>

            <h1 class="text-center">Modifier Le Profil</h1>
            <div class="blank"></div>
            <div class="container">
                <form action="?do=update" method="POST">
                    <input type="hidden" name="userID" value="<?php echo $userid; ?>">
                    <div class="form-group">
                        <label for="formGroupExampleInput">UserName</label>
                        <input name="username" type="text" class="form-control" id="UserName" value="<?php echo $row['username'] ?>" autocomplete="off" placeholder="UserName" required>
                    </div>
                    <div class="form-group">
                        <label for="formGroupExampleInput2">Password</label>
                        <input name="oldpassword" type="hidden" class="form-control" value="<?php echo $row['password'] ?>" id="formGroupExampleInput2" autocomplete="off" placeholder="Password">
                        <input name="newpassword" type="password" class="form-control" id="formGroupExampleInput2" autocomplete="off" placeholder="Si vous pas voulez changer le mot de pass laisse ce champ vide">
                    </div>
                    <div class="form-group">
                        <label for="formGroupExampleInput3">Email</label>
                        <input name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" type="email" class="form-control" id="formGroupExampleInput3" value="<?php echo $row['email'] ?>" autocomplete="off" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <label for="formGroupExampleInput4">Fullname</label>
                        <input name="fullname" type="text" class="form-control" id="formGroupExampleInput4" value="<?php echo $row['fullname'] ?>" autocomplete="off" placeholder="Fullname">
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

            echo '<h1 class="text-center">Update Des Membres</h1>';
            echo '<div class="blank"></div>';

            $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);

            $id         = $_POST['userID'];
            $username   = $_POST['username'];
            $email      = $_POST['email'];
            $fullname   = $_POST['fullname'];

            $errorMsg = array();

            if (strlen($username) < 4 || strlen($username) > 10) {
                $errorMsg[] = "username doit etre entre 4 et 10 charactéres";
            }
            if (empty($email)) {
                $errorMsg[] = "email can't be empty";
            }
            if (empty($fullname)) {
                $errorMsg[] = "fullname can't be empty";
            }

            foreach ($errorMsg as $err) {
                // echo $err . "<br>";
                echo '<div class="alert alert-danger" role="alert">' . $err . '</div>';
            }

            if (empty($errorMsg)) {
                if ((checkIfExists("username", "users", $username)) === 0) {
                    $stmt = $db->prepare("UPDATE users SET username=? , email =? , fullname=?, password=? WHERE userID=?");
                    $stmt->execute(array($username, $email, $fullname, $pass, $id));
                    $nombreModif = $stmt->rowCount();

                    echo '<div class="alert alert-success" role="alert">Modification faite avec succes , nombre des modifications est: ' .  $nombreModif . '</div>';
                    echo '<div class="container text-center">';
                    echo '<a class="btn btn-primary text-center" href="http://localhost/Brief10/admin/members.php">RETOUR</a>';
                    echo '</div>';
                } else {
                    echo '<div class="alert alert-danger" role="alert">Ce nom d\'utilisateur deja exists</div>';
                    echo '<div class="container text-center">';
                    echo '<a class="btn btn-primary text-center" href="http://localhost/Brief10/admin/members.php">RETOUR</a>';
                    echo '</div>';
                }
            }
        } else {

            $errorMsg = 'Tu peut pas entrer directement dans cette page';
            redirect($errorMsg, 5);
        }
    } elseif ($do == 'delete') {

        $userid = isset($_GET['userID']) && is_numeric($_GET['userID']) ? intval($_GET['userID']) : 0;

        // echo '<h1 class="text-center">' . $count .'</h1>';

        $countID = checkIfExists("userID", "users", $userid);

        if ($countID > 0) {
            $stmt = $db->prepare("DELETE FROM users WHERE userID = ?");
            $stmt->execute(array($userid));
            $count = $stmt->rowCount();
            echo '<h1 class="text-center">DELETED !!</h1>';
            echo '<div class="blank"></div>';
            echo '<div class="alert alert-success" role="alert">La supression est faite avec succes , ' .  $count . ' éléments suprimmé' . '</div>';
            echo '<div class="container text-center">';
            echo '<a class="btn btn-primary" href="http://localhost/Brief10/admin/members.php">RETOUR</a>';
            echo '</div>';
        } else {
            $errorMsg = 'Y\'a pas un membre avec ce ID';

            redirect($errorMsg, 5, "members");
        }
    } elseif ($do == 'activate') {

        $userid = isset($_GET['userID']) && is_numeric($_GET['userID']) ? intval($_GET['userID']) : 0;

        // echo '<h1 class="text-center">' . $count .'</h1>';

        $countID = checkIfExists("userID", "users", $userid);

        if ($countID > 0) {
            $stmt = $db->prepare("UPDATE users SET regStatus=1 WHERE userID=?");
            $stmt->execute(array($userid));
            $count = $stmt->rowCount();
            echo '<h1 class="text-center">Activation complete !!</h1>';
            echo '<div class="blank"></div>';
            echo '<div class="alert alert-success" role="alert">L\'activation est faite avec succes , ' .  $count . ' éléments activé' . '</div>';
            echo '<div class="container text-center">';
            echo '<a class="btn btn-primary" href="http://localhost/Brief10/admin/members.php">RETOUR</a>';
            echo '</div>';
        } else {
            $errorMsg = 'Y\'a pas un membre avec ce ID';

            redirect($errorMsg, 5, "members");
        }
    } else {

        $errorMsg = 'Tu peut pas entrer directement dans cette page';

        redirect($errorMsg, 5);
    }

    include $tplDirName . "footer.php";
} else {
    header('location: index.php');
}
