<?php


use Alexplusde\YComFastForward\YComFastForward;

$addon = rex_addon::get('ycom_fast_forward');

// Wenn Modul mit key "ycom_fast_forward" nicht existiert, dann Modul installieren
$module = rex_sql::factory()->setQuery('SELECT id FROM ' . rex::getTablePrefix() . 'module WHERE `key` = "ycom_fast_forward"');

if($module->getRows() === 0) {

    $input = rex_file::get(rex_path::addon('ycom_fast_forward', 'install/module/input.php'));
    $output = rex_file::get(rex_path::addon('ycom_fast_forward', 'install/module/output.php'));

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

/* Falls erste Installation, dann Datum speichern */
if(YComFastForward::getConfig('first_install') === '0000-00-00 00:00:00') {
    YComFastForward::setConfig('first_install', date('Y-m-d H:i:s'));
} else {
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

/* Extension-Points CAT_ADDED und ART_ADDED nutzen, um eben erstllte Kategorie zu finden und weitere Artikel / Slices anzulegen */

rex_extension::register('CAT_ADDED', [YComFastForward::class, "CatAdded"]);
rex_extension::register('ART_ADDED', [YComFastForward::class, "ArtAdded"]);

$module_id = rex_sql::factory()->setQuery('SELECT id FROM ' . rex::getTablePrefix() . 'module WHERE `key` = "ycom_fast_forward"')->getValue('id');

/* Modul-ID als Addon-Property speichern */
$addon->setProperty('module_id', $module_id);


// TODO: Attribut ycom_auth_type = `2` für nicht eingeloggte Nutzer
rex_category_service::addCategory(0, [
    'catname' => 'Login',
    'catpriority' => 1,
    'templateId' => null,
    'name' => null,
    'status' => 1,
]);

// TODO: Attribut ycom_auth_type = `1` für eingeloggte Nutzer
rex_category_service::addCategory(0, [
    'catname' => 'Mein Profil',
    'catpriority' => 2,
    'templateId' => null,
    'name' => 'Übersicht',
    'status' => 1,
]);

// TODO: Attribut ycom_auth_type = `1` für eingeloggte Nutzer
rex_category_service::addCategory(0, [
    'catname' => 'Logout',
    'catpriority' => 3,
    'templateId' => null,
    'name' => 'Logout',
    'status' => 1,
]);

// YCom-Nutzer anlegen
if(rex_ycom_user::query()->where('email', 'mail@example.org')->findOne() === null) {
    rex_ycom_user::createUserByEmail(['email' => 'mail@example.org']);
}
