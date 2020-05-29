<?php 

function lang($phrase) {

    static $lang = array (
        'message'   => 'السلام عليكم',
        'admin'     => 'سيدي المدير'
    );

    return $lang[$phrase];

}