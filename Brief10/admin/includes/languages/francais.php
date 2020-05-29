<?php

function lang($phrase)
{

    static $lang = array(
        'homePage'          => 'Acceuil',
        'Logo'              => 'YouSHOP',
        'membrePage'        => 'Membres',
        'categoriePage'     => 'Catégories',
        'productPage'       => 'Produits',
        'cartPage'          => 'Panier',
        'settingPage'       => 'Paramétre',
        'logoutPage'        => 'Se déconnecter',
        'editMembers'       => 'Modifier les membres',
        'editProfile'       => 'Modifier le profil',
    );

    return $lang[$phrase];
}
