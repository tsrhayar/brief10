<?php
$noNavBar = '';
$pagetitle = 'Produits';
$noHeader = '';

include "init.php"; // include init

$do = isset($_GET['do']) ? $_GET['do'] : 'add';

if ($do == 'add') {

    //// $userid = $_SESSION['admin'];
    //// $stmt = $db->prepare("SELECT * FROM users WHERE userID = ? LIMIT 1");
    //// $stmt->execute(array($userid));
    //// $row = $stmt->fetch();
    //// $count = $stmt->rowCount();
?>

    <h1 class="text-center">Inscription</h1>
    <div class="blank"></div>
    <div class="container">
        <form action="?do=insert" method="POST">
            <input type="hidden" name="userID" value="<?php echo $userid; ?>">
            <div class="form-group">
                <label for="formGroupExampleInput">Nom d`utilisateur</label>
                <input name="username" type="text" class="form-control" id="UserName" placeholder="Nom d`utilisateur" autocomplete="off" required>
            </div>
            <div class="form-group">
                <label for="formGroupExampleInput2">Mot de passe</label>
                <input name="password" type="password" class="form-control" id="formGroupExampleInput2" autocomplete="off" placeholder="Mot de passe" required>
            </div>
            <div class="form-group">
                <label for="formGroupExampleInput3">E-mail</label>
                <input name="email" type="email" class="form-control" id="formGroupExampleInput3" autocomplete="off" placeholder="E-mail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
            </div>
            <div class="form-group">
                <label for="formGroupExampleInput4">Le nom complet</label>
                <input name="fullname" type="text" class="form-control" id="formGroupExampleInput4" autocomplete="off" placeholder="Le nom complet" required>
            </div>
            <div class="form-group">
                <input type="submit" value="inscrivez-vous" class="btn btn-primary">
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

            echo '<div class="alert alert-success" role="alert">L\'inscription est faite avec succes' . '</div>';
            echo '<div class="container text-center">';
            echo '<a class="btn btn-primary text-center" href="http://localhost/Brief10/admin/index.php">RETOUR</a>';
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
}
?>

<?php include $tplDirName . "footer.php"; // include la page (footer) 
?>