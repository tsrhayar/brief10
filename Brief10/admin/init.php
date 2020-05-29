<?php

include "connect.php";

// dirName de dossier (Routes)

$langDirName    = "includes/languages/";
$tplDirName     = "includes/templates/";
$funcDirName    = "includes/functions/";
$cssDirName     = "layout/css/";
$jsDirName      = "layout/js/";

// include pages

include $langDirName . "francais.php";
include $tplDirName . "header.php";
include $funcDirName . "functions.php";

if (!isset($noNavBar)) {
    include $tplDirName . "navbar.php";
}
if (!isset($noHeader)) {
    include $tplDirName . "myHeader.php";
} else {
    include $tplDirName . "titleOfPage.php";
}
