<?php

/* ycom_fast_forward.access_request */

// Überprüfen, ob der Datensatz mit dem Namen bereits existiert
if (rex_sql::factory()->setQuery('SELECT id FROM ' . rex::getTable('yform_email_template') . ' WHERE name = "access_request"')->getRows() > 0) {
    return;
}

rex_sql::factory()
->setTable(rex::getTable('yform_email_template'))
->setValue('name', 'ycom_fast_forward.access_request')
->setValue('mail_from', rex_config::get('phpmailer', 'from') ?? 'noreply@' . $_SERVER['HTTP_HOST'])
->setValue('mail_from_name', rex_config::get('phpmailer', 'fromname'))
->setValue('subject', 'Zugriffsanfrage')
->setValue('body_html',
"<?php
$article_id = 999; // Hier die Artikel-ID der Bestätigungsseite eintragen

$article_url = rex_getUrl($article_id,'',array('rex_ycom_activation_key'=>'REX_YFORM_DATA[field=activation_key]','rex_ycom_id'=>'REX_YFORM_DATA[field=email]'));
$full_url = trim(rex::getServer(),'/').trim($article_url,'.');
?>
<p>Bitte klicken Sie diesen Link, um die Anmeldung zu bestätigen:</p>
<p><a href=\"<?=$full_url;?>\"><?=$full_url;?></a></p>")
->setValue('updatedate', date('Y-m-d H:i:s'))
->insert();

/* ycom_otp_code_template */

rex_sql::factory()
->setTable(rex::getTable('yform_email_template'))
->setValue('name', 'ycom_otp_code_template')
->setValue('mail_from', rex_config::get('phpmailer', 'from') ?? 'noreply@' . $_SERVER['HTTP_HOST'])
->setValue('mail_from_name', rex_config::get('phpmailer', 'fromname'))
->setValue('subject', 'Ihr Einmalpasswort')
->setValue('body_html',
"<p>Ihr Einmalpasswort lautet: <strong>REX_YFORM_DATA[field=otp_code]</strong></p>")
->setValue('updatedate', date('Y-m-d H:i:s'))
->insert();
