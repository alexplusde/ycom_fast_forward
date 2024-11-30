<?php
/* Alle Fragmente in redaxo/src/addons/ycom_fast_forward/fragments/ycom_fast_forward/* als Select zur Auswahl stellen */

$fragment_files = glob(rex_path::addon('ycom_fast_forward', 'fragments/ycom_fast_forward/') . '*.php');
$fragment_select = new rex_select();
$fragment_select->setName('REX_INPUT_VALUE[1]');
$fragment_select->setAttribute('class', 'form-control');
$fragment_select->setAttribute('required', 'required');
$fragment_select->addOption(rex_i18n::msg("ycom_fast_forward.module.select.default"), '');

foreach ($fragment_files as $fragment_file) {
    $fragment_select->addOption(basename($fragment_file), basename($fragment_file));
}

echo $fragment_select->get();

?>
