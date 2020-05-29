<?php
session_start();

if (isset($_SESSION['admin']) || isset($_SESSION['user'])) {

    $pagetitle = 'Pannier';
    include "init.php"; // include init

    $stmt = $db->prepare("SELECT * FROM pannier WHERE p_u_id = ?");
        $stmt->execute(array($_SESSION['id']));

        $rows = $stmt->fetchAll();

        echo $_SESSION['id'];

        echo "<pre>";
        print_r($_SESSION);
        echo "</pre>";

    // $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

    // if ($do == 'manage') {

    // } elseif ($do == 'add') {

    // } elseif ($do == 'insert') {

    // } elseif ($do == 'edit') { // edit page 

    // } elseif ($do == 'update') {

    // } elseif ($do == 'delete') {
        
    // }
    include $tplDirName . "footer.php";
} else {
    header('location: index.php');
}