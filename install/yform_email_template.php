<?php

/* ycom_fast_forward.activation_key */

// Überprüfen, ob der Datensatz mit dem Namen bereits existiert
if (rex_sql::factory()->setQuery('SELECT id FROM ' . rex::getTable('yform_email_template') . ' WHERE name = "activation_key"')->getRows() > 0) {
    return;
}

rex_sql::factory()
->setTable(rex::getTable('yform_email_template'))
->setValue('name', 'ycom_fast_forward.activation_key')
->setValue('mail_from', rex_config::get('phpmailer', 'from') ?? 'noreply@' . $_SERVER['HTTP_HOST'])
->setValue('mail_from_name', rex_config::get('phpmailer', 'fromname'))
->setValue('subject', 'Zugriffsanfrage')
->setValue('body',
"<?php

$fragment = new rex_fragment();
$fragment->setVar('file', 'register.activation_key.plaintext.php');
$fragment->setVar('email', 'REX_YFORM_DATA[field=email]');
$fragment->setVar('activation_key', 'REX_YFORM_DATA[field=activation_key]');

echo $fragment->render('yform_fast_forward/yform_email/template.plaintext.php');
?>")
->setValue('body_html',
"<?php

$fragment = new rex_fragment();
$fragment->setVar('file', 'register.activation_key.html.php');
$fragment->setVar('email', 'REX_YFORM_DATA[field=email]');
$fragment->setVar('activation_key', 'REX_YFORM_DATA[field=activation_key]');

echo $fragment->render('yform_fast_forward/yform_email/template.plaintext.php');
?>")
->setValue('updatedate', date('Y-m-d H:i:s'))
->insert();

/* ycom_otp_code_template */

rex_sql::factory()
->setTable(rex::getTable('yform_email_template'))
->setValue('name', 'ycom_otp_code_template')
->setValue('mail_from', rex_config::get('phpmailer', 'from') ?? 'noreply@' . $_SERVER['HTTP_HOST'])
->setValue('mail_from_name', rex_config::get('phpmailer', 'fromname'))
->setValue('subject', 'Login-Versuch: Ihr Einmalcode')
->setValue('body',
"<?php

$fragment = new rex_fragment();
$fragment->setVar('file', 'register.otp_code.plaintext.php');
$fragment->setVar('otp_code', 'REX_YFORM_DATA[field=otp_code]');

echo $fragment->render('yform_fast_forward/yform_email/template.plaintext.php');
?>"
)
->setValue('body_html',
"<?php

$fragment = new rex_fragment();
$fragment->setVar('file', 'register.otp_code..php');
$fragment->setVar('otp_code', 'REX_YFORM_DATA[field=otp_code]');

echo $fragment->render('yform_fast_forward/yform_email/template.html.php');
?>
")
->setValue('updatedate', date('Y-m-d H:i:s'))
->insert();
