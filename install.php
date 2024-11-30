<?php

// Wenn Modul mit key "ycom_fast_forward" nicht existiert, dann Modul installieren

use Alexplusde\YComFastForward\YComFastForward;

$input = rex_file::get(rex_path::addon('ycom_fast_forward', 'install/module/input.php'));
$output = rex_file::get(rex_path::addon('ycom_fast_forward', 'install/module/output.php'));

$module = rex_sql::factory()->setQuery('SELECT id FROM ' . rex::getTablePrefix() . 'module WHERE key = "ycom_fast_forward"');

if($module->getRows() == 0) {
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
    ->setWhere('key = "ycom_fast_forward"')
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

$module_id = rex_sql::factory()->setQuery('SELECT id FROM ' . rex::getTablePrefix() . 'module WHERE key = "ycom_fast_forward"')->getValue('id');

rex_category_service::addCategory(0, [
    'name' => 'Login',
    'priority' => 0,
    'attributes' => [
        'ycom_auth' => 'login'
    ]
]);

$login_id = rex_category::get(1)->getId();

rex_article_service::addArticle([
    'parent_id' => $login_id,
    'name' => 'Login-Formular',
    'template_id' => null,
    'status' => 1,
    'clang_id' => 1,
    'startarticle' => 0,
    'catpriority' => 0,
    'path' => 'ycom_fast_forward/login',
    'attributes' => [
        'ycom_auth' => 'login'
    ]
]);

$login_form_id = rex_article::get(2)->getId();

rex_article_slice::__set_state([
    'article_id' => rex_article::get($login_form_id)->getId(),
    'ctype_id' => 1,
    'modultyp_id' => $module_id,
    'priority' => 0,
    'attributes' => [
        'ycom_auth' => 'login'
    ]
]);
