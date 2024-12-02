<?php

rex_sql_table::get(rex::getTable('ycom_fast_forward_activation_key'))
    ->ensurePrimaryIdColumn()
    ->ensureColumn(new rex_sql_column('ycom_user_id', 'int(10) unsigned'))
    ->ensureColumn(new rex_sql_column('status', 'tinyint(1)'))
    ->ensureColumn(new rex_sql_column('activation_key', 'varchar(191)'))
    ->ensureColumn(new rex_sql_column('createdate', 'datetime'))
    ->ensureColumn(new rex_sql_column('expiredate', 'datetime'))
    ->ensureColumn(new rex_sql_column('deletedate', 'datetime'))
    ->ensureColumn(new rex_sql_column('updatedate', 'datetime'))
    ->ensureColumn(new rex_sql_column('comment', 'varchar(191)', false, ''))
    ->ensureIndex(new rex_sql_index('activation_key', ['activation_key'], rex_sql_index::UNIQUE))
    ->ensureIndex(new rex_sql_index('deletedate', ['deletedate']))
    ->ensure();

// Tableset installieren
if (rex::isBackend() && rex::getUser()) {
    rex_yform_manager_table_api::importTablesets(rex_path::addon('ycom_fast_forward', 'install/ycom_fast_forward_activation_key.tableset.json'));
}
