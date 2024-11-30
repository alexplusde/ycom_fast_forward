<?php
/* Passendes Fragment ausgeben, Parameter des Dateinamens in REX_VALUE[1] */
$file = "REX_VALUE[1]";

$fragment = new rex_fragment();
$fragment->setVar('file', $file, false);
echo $fragment->parse('ycom_fast_forward.php');

?>
