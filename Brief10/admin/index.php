<?php
session_start(); // ouvrir une session
$noNavBar = '';
$noHeader = '';
$pagetitle = "Home";
$titleOfPage = 'Login';
if (isset($_SESSION['admin'])) { // si il y'a une session ouvert
    header('location: dashbord.php'); // redirect vers la page dashbord
    exit();
} elseif (isset($_SESSION['user'])) {
    header('location: dashbord.php');
    exit();
}

include "init.php"; // include init

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // si la methode de la formulaire est POST

    $username = $_POST['user'];
    $password = $_POST['pass'];
    $shapassword = sha1($password);

    $stmt = $db->prepare("SELECT userID, username, password FROM users WHERE username = ? AND password = ? AND groupeID = 1");
    $stmt->execute(array($username, $shapassword));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();

    if ($count > 0) {
        $_SESSION['admin'] = $username; // SESSION USERNAME
        $_SESSION['id'] = $row['userID']; // SESSION ID
        header('location: manageproducts.php'); // REDIRECT VERS PAGE DASHBORD
        exit();
    }

    $stmt2 = $db->prepare("SELECT userID, username, password FROM users WHERE username = ? AND password = ? AND groupeID = 0");
    $stmt2->execute(array($username, $shapassword));
    $row2 = $stmt2->fetch();
    $count2 = $stmt2->rowCount();

    if ($count2 > 0) {
        $_SESSION['user'] = $username; // SESSION USERNAME
        $_SESSION['id'] = $row2['userID']; // SESSION ID
        header('location: dashbord.php'); // REDIRECT VERS PAGE PRODUCTS
        exit();
    }
}

?>


<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off">
    <input class="form-control" type="text" name="pass" placeholder="Password" autocomplete="new-password">
    <input type="submit" class="btn btn-primary btn-block" value="login">
    <a href="sign-up.php">S'inscrire sur notre site</a>
</form>


<?php include $tplDirName . "footer.php"; // include la page (footer) 
?>