<?php

use Alexplusde\YComFastForward\YComFastForward;

/** @var rex_addon $this */

if (rex::isBackend()) {
    if ('ycom_fast_forward/settings' === rex_be_controller::getCurrentPage()) {
        rex_extension::register('OUTPUT_FILTER', static function (rex_extension_point $ep) {
            $suchmuster = 'class="###ycom_fast_forward-settings-editor###"';
            $ersetzen = strval(rex_config::get('ycom_fast_forward', 'editor'));
            $ep->setSubject(str_replace($suchmuster, $ersetzen, $ep->getSubject()));
        });
    }
}

$module_id = rex_sql::factory()->setQuery('SELECT id FROM ' . rex::getTablePrefix() . 'module WHERE `key` = "ycom_fast_forward"')->getValue('id');

/* Modul-ID als Addon-Property speichern */
$addon = rex_addon::get('ycom_fast_forward');
$addon->setProperty('module_id', $module_id);

/*
rex_category_service::addCategory(0, [
    'catname' => 'Login',
    'catpriority' => 1,
    'templateId' => null,
    'name' => null,
    'status' => 1,
]);
*/
// rex_article_content prüfen, ob slices vorhanden sind



/* REX_EXTENSION_POINT nutzen, um eben erstllte Kategorie zu finden und Artikel anzulegen */

rex_extension::register('CAT_ADDED', [YComFastForward::class, "CatAdded"]);
rex_extension::register('ART_ADDED', [YComFastForward::class, "ArtAdded"]);
