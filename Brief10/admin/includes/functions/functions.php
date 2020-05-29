<?php

function pagesTilte()
{
    global $pagetitle;
    if (isset($pagetitle)) {
        echo $pagetitle;
    }
    if (!isset($pagetitle)) {
        echo "default page";
    }
}

function redirect($errorMsg, $second = 3, $page = "index")
{
    echo '<div class="alert alert-danger text-center" role="alert">' . $errorMsg . '</div>';
    echo '<div class="alert alert-primary text-center" role="alert">Redirect à la page ' . $page . ' dans ' . $second . ' seconds</div>';

    header("refresh:$second; url=$page.php");
    exit();
}

function checkIfExists($select, $from, $value)
{
    global $db;
    $statement = $db->prepare(("SELECT $select FROM $from WHERE $select = ?"));
    $statement->execute(array($value));

    $check = $statement->rowCount();
    // echo $check;
    return $check;
}

function nmbrItms($item, $table)
{
    global $db;
    $stmt2 = $db->prepare("SELECT COUNT($item) FROM $table");
    $stmt2->execute();

    return $stmt2->fetchColumn();
}
