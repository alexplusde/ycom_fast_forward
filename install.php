<?php


use Alexplusde\YComFastForward\YComFastForward;

$addon = rex_addon::get('ycom_fast_forward');

// Wenn Modul mit key "ycom_fast_forward" nicht existiert, dann Modul installieren
$module = rex_sql::factory()->setQuery('SELECT id FROM ' . rex::getTablePrefix() . 'module WHERE `key` = "ycom_fast_forward"');

$input = rex_file::get(rex_path::addon('ycom_fast_forward', 'install/module/input.php'));
$output = rex_file::get(rex_path::addon('ycom_fast_forward', 'install/module/output.php'));

if ($module->getRows() === 0) {

    /* Modul anlegen */
    rex_sql::factory()
        ->setTable(rex::getTablePrefix() . 'module')
        ->setValue('name', 'translate:ycom_fast_forward.module.name')
        ->setValue('key', 'ycom_fast_forward')
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
if (YComFastForward::getConfig('first_install') === '0000-00-00 00:00:00') {
    YComFastForward::setConfig('first_install', date('Y-m-d H:i:s'));
} else {
    YComFastForward::setConfig('first_install', date('Y-m-d H:i:s'));
    // return;
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

/* Root-Kategorie anhand Startartikel ermitteln */
$siteStartArticleId = rex_article::getSiteStartArticleId();
$siteStartCategory = rex_category::get($siteStartArticleId);

$root_id = 0;
if($siteStartCategory !== null) {
    $root_id = $siteStartCategory->getId();
}


rex_category_service::addCategory($root_id, [
    'catname' => 'Login',
    'catpriority' => 1,
    'templateId' => null,
    'name' => null,
    'status' => 1,
]);

$category_login = rex_category::get(rex_addon::get('ycom_fast_forward')->getProperty('category_id_login'));

if ($category_login !== null) {

    YComFastForward::setYcomAuthForArticle($category_login->getId(), 2);

    $clang_id = $category_login->getClangId();
    
    // Passwort vergessen
    rex_article_service::addArticle([
        'name' => 'Passwort vergessen',
        'category_id' => $category_login->getId(),
        'priority' => 1,
        'template_id' => 0,
        'status' => 1,
        'clang_id' => $clang_id
    ]);

    // OTP-Verifizierung
    rex_article_service::addArticle([
        'category_id' => $category_login->getId(),
        'name' => 'OTP-Verifizierung',
        'priority' => 2,
        'template_id' => 0,
        'status' => 1,
        'clang_id' => $clang_id
    ]);

    // Registrierung
    rex_article_service::addArticle([
        'category_id' => $category_login->getId(),
        'name' => 'Registrierung',
        'priority' => 3,
        'template_id' => 0,
        'status' => 1,
        'clang_id' => $clang_id
    ]);
}

rex_category_service::addCategory($root_id, [
    'catname' => 'Mein Profil',
    'catpriority' => 2,
    'templateId' => null,
    'name' => 'Übersicht',
    'status' => 1,
]);

$category_myprofile = rex_category::get(rex_addon::get('ycom_fast_forward')->getProperty('category_id_myprofile'));

if ($category_myprofile !== null) {

    YComFastForward::setYcomAuthForArticle($category_myprofile->getId(), 1);

    $clang_id = $category_myprofile->getClangId();

    // Nutzungsbedingungen
    rex_article_service::addArticle([
        'category_id' => $category_myprofile->getId(),
        'name' => 'Nutzungsbedingungen akzeptieren',
        'priority' => 1,
        'template_id' => 0,
        'status' => 1,
        'clang_id' => $clang_id
    ]);
    // Profil bearbeiten
    rex_article_service::addArticle([
        'category_id' => $category_myprofile->getId(),
        'name' => 'Mein Profil',
        'priority' => 2,
        'template_id' => 0,
        'status' => 1,
        'clang_id' => $clang_id
    ]);

    // Passwort ändern
    rex_article_service::addArticle([
        'category_id' => $category_myprofile->getId(),
        'name' => 'Passwort ändern',
        'priority' => 3,
        'template_id' => 0,
        'status' => 1,
        'clang_id' => $clang_id
    ]);
}

rex_category_service::addCategory($root_id, [
    'catname' => 'Logout',
    'catpriority' => 3,
    'templateId' => null,
    'name' => 'Logout',
    'status' => 1,
]);

$category_logout = rex_category::get(rex_addon::get('ycom_fast_forward')->getProperty('category_id_logout'));

if ($category_logout !== null) {

    YComFastForward::setYcomAuthForArticle($category_logout->getId(), 1);

    $clang_id = $category_logout->getClangId();

    // Logout
    rex_article_service::addArticle([
        'category_id' => $category_logout->getId(),
        'name' => 'Logout',
        'priority' => 1,
        'template_id' => 0,
        'status' => 1,
        'clang_id' => $clang_id
    ]);
}

// Prüfe, ob Feld `rex_ycom_user`.`lastname` existiert

if (rex_yform_manager_table::get('rex_ycom_user')->getFields()['lastname'] === null) {
    \rex_yform_manager_table_api::setTableField(
        'rex_ycom_user',
        [
            'prio' => '11',
            'type_id' => 'value',
            'type_name' => 'text',
            'db_type' => 'varchar(191)',
            'list_hidden' => '0',
            'search' => '1',
            'name' => 'lastname',
            'label' => 'translate:ycom_lastname',
            'default' => '',
            'createuser' => 'ycom_fast_forward',
            'updateuser' => 'ycom_fast_forward',
        ]
    );
}

\rex_yform_manager_table_api::generateTableAndFields(rex_yform_manager_table::get('rex_ycom_user'));

// YCom-Nutzer anlegen
if (rex_ycom_user::query()->where('email', 'mail@example.org')->findOne() === null) {
    rex_ycom_user::createUserByEmail([
        'firstname' => 'Blue',
        'lastname' => 'T-Rex',
        'name' => 'Blue T-Rex',
        'email' => 'mail@example.org'
    ]);
}

// E-Mail-Templates anlegen
include_once(__DIR__ . '/install/yform_email_template.php');

// Table Manager Profil für ycom_fast_forward_activation_key anlegen
include_once(__DIR__ . '/install/ycom_fast_forward_activation_key.php');
