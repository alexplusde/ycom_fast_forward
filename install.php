<?php

// Wenn Modul mit key "ycom_fast_forward" nicht existiert, dann Modul installieren

use Alexplusde\YComFastForward\YComFastForward;

$input = rex_file::get(rex_path::addon('ycom_fast_forward', 'install/module/input.php'));
$output = rex_file::get(rex_path::addon('ycom_fast_forward', 'install/module/output.php'));

$module = rex_sql::factory()->setQuery('SELECT id FROM ' . rex::getTablePrefix() . 'module WHERE `key` = "ycom_fast_forward"');

if($module->getRows() === 0) {
    /* Modul anlegen */
    rex_sql::factory()
    ->setTable(rex::getTablePrefix() . 'module')
    ->setValue('name', 'translate:ycom_fast_forward.module.name')
    ->setValue('input', $input)
    ->setValue('output', $output)
    ->setValue('createuser', 'ycom_fast_forward')
    ->setValue('updateuser', 'ycom_fast_forward')
    ->insert();
} else {
    /* Modul aktualisieren */
    rex_sql::factory()
    ->setTable(rex::getTablePrefix() . 'module')
    ->setWhere('`key` = "ycom_fast_forward"')
    ->setValue('input', $input)
    ->setValue('output', $output)
    ->setValue('updateuser', 'ycom_fast_forward')
    ->update();
}

if(YComFastForward::getConfig('first_install') !== '0000-00-00 00:00:00') {
    YComFastForward::setConfig('first_install', date('Y-m-d H:i:s'));
    return;
}

/* Als nächstes die benötigten Artikel in REDAXO programmatisch anlegen und Slices (Blöcke) hinzufügen

Benötigte Kategorien / Artikel für YCom Fast Forward:
* Login
* * Loginformular
* * Passwort vergessen
* * Passwort zurücksetzen
* * Registrierung
* Mein Profil
* * Profil bearbeiten
* * Passwort ändern
* * OTP-Verifizierung
* * Nutzungsbedingungen akzeptieren
* Logout
*/
