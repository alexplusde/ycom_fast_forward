<?php

$addon = rex_addon::get('ycom_fast_forward');

echo rex_view::title($addon->i18n('wsm_title'));

$table_name = 'rex_ycom_fast_forward_profile';

rex_extension::register(
    'YFORM_MANAGER_DATA_PAGE_HEADER',
    static function (rex_extension_point $ep) {
        if ($ep->getParam('yform')->table->getTableName() === $ep->getParam('table_name')) {
            return '';
        }
    },
    rex_extension::EARLY,
    ['table_name' => $table_name],
);

// @phpstan-ignore-next-line
$_REQUEST['table_name'] = $table_name;

include rex_path::plugin('yform', 'manager', 'pages/data_edit.php');
