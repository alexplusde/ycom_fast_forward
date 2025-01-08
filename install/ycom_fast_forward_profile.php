<?php

rex_sql_table::get(rex::getTable('ycom_fast_forward_profile'))
    ->ensurePrimaryIdColumn()
    ->ensureColumn(new rex_sql_column('yrewrite_domain_id', 'int(11)'))
    ->ensureColumn(new rex_sql_column('article_id_login', 'int(11)'))
    ->ensureColumn(new rex_sql_column('article_id_logout', 'int(11)'))
    ->ensureColumn(new rex_sql_column('article_id_jump_ok', 'int(11)'))
    ->ensureColumn(new rex_sql_column('article_id_jump_logout', 'int(11)'))
    ->ensureColumn(new rex_sql_column('article_id_jump_denied', 'int(11)'))
    ->ensureColumn(new rex_sql_column('article_id_password', 'int(11)'))
    ->ensureColumn(new rex_sql_column('mailer_profile_id', 'text'))
    ->ensureColumn(new rex_sql_column('email_template_otp', 'varchar(191)'))
    ->ensureColumn(new rex_sql_column('email_template_password', 'varchar(191)'))
    ->ensureColumn(new rex_sql_column('dashboard_article_id', 'int(11)'))
    ->ensureColumn(new rex_sql_column('resetpassword_article_id', 'int(11)'))
    ->ensure();

// Tableset installieren
if (rex::isBackend() && rex::getUser()) {
    rex_yform_manager_table_api::importTablesets(rex_path::addon('ycom_fast_forward', 'install/ycom_fast_forward_profile.tableset.json'));
}
