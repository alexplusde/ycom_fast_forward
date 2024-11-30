<?php
/* Passendes Fragment ausgeben, Parameter des Dateinamens in REX_VALUE[1] */

use Alexplusde\YComFastForward\YComFastForward;

$title = "REX_VALUE[1]";
$description = "REX_VALUE[2 output=html]";

$file = "REX_VALUE[10]" ? "REX_VALUE[10]" : "index.php";

if(rex_addon::get('ycom_fast_forward')->isAvailable()) {
    echo YComFastForward::parse($file, $title, $description);
    return;
} else {
    echo rex_view::error('Das Modul "YCom Fast Forward" ist nicht installiert oder aktiviert.');
}

?>
