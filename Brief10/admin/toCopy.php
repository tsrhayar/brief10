<?php
session_start();

if (isset($_SESSION['admin'])) {

    $pagetitle = 'Membres';
    include "init.php"; // include init

    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

    if ($do == 'manage') {

    } elseif ($do == 'add') {

    } elseif ($do == 'insert') {

    } elseif ($do == 'edit') { // edit page 

    } elseif ($do == 'update') {

    } elseif ($do == 'delete') {
        
    }
    include $tplDirName . "footer.php";
} else {
    header('location: index.php');
}
