<?php

/* Konfigurationsformular, um Einstellungen abzufragen: WYSIWYG-Editor Nutzungsbedingungen */

use Alexplusde\YComFastForward\YComFastForward;

/* Titel ausgeben */
echo rex_view::title(rex_i18n::msg('ycom_fast_forward.title'));

$addon = rex_addon::get('ycom_fast_forward');

$form = rex_config_form::factory($addon->getName());

$form->addFieldset(rex_i18n::msg('ycom_fast_forward.settings.title'));

/* Auswahl des Standard-Status für neue Nutzer */
$field = $form->addSelectField('ycom_user_default_status', null, ['class' => 'form-control']);
$field->setLabel(rex_i18n::msg('ycom_fast_forward.config.ycom_user_default_status'));
$field->setNotice(rex_i18n::msg('ycom_fast_forward.config.ycom_user_default_status.notice'));

$select = $field->getSelect();
$select->setSize(1);

$options = explode(",",'translate:ycom_account_inactive_termination=-3,translate:ycom_account_inactive_logins=-2,translate:ycom_account_inactive=-1,translate:ycom_account_requested=0,translate:ycom_account_confirm=1,translate:ycom_account_active=2');
foreach ($options as $option) {
    $option = explode('=', $option);
    $label = substr($option[0], 10);
    $select->addOption(rex_i18n::msg($label), $option[1]);
}

/* Textfeld zur Eingabe des Objparams für das gewünschte YForm Theme */

$field = $form->addTextField('yform_theme', null, ['class' => 'form-control']);
$field->setLabel(rex_i18n::msg('ycom_fast_forward.config.yform_theme'));
$field->setNotice(rex_i18n::msg('ycom_fast_forward.config.yform_theme.notice'));

$form->addFieldset(rex_i18n::msg('ycom_fast_forward.config.terms_of_use'));

/* Textfeld zur Eingabe der Nutzungsbedingungen */

$editor = YComFastForward::getConfig('editor');

/* Auswahl, ob Nutzungsbedingungen zugestimmt werden muss oder nicht */
$field = $form->addSelectField('terms_of_use_required', null, ['class' => 'form-control']);
$field->setLabel(rex_i18n::msg('ycom_fast_forward.config.terms_of_use_required'));
$field->setNotice(rex_i18n::msg('ycom_fast_forward.config.terms_of_use_required.notice'));

$select = $field->getSelect();
$select->setSize(1);
$select->addOption(rex_i18n::msg('ycom_fast_forward.config.terms_of_use_required.no'), '0');
$select->addOption(rex_i18n::msg('ycom_fast_forward.config.terms_of_use_required.yes'), '1');

/* Auswahl der passenden YCom-Gruppe bei Registrierung */

$field = $form->addSelectField('default_ycom_group_id', null, ['class' => 'form-control']);
$field->setLabel(rex_i18n::msg('ycom_fast_forward.config.default_ycom_group_id'));
$field->setNotice(rex_i18n::msg('ycom_fast_forward.config.default_ycom_group_id.notice'));

$select = $field->getSelect();
$select->setSize(1);
$select->addOption(rex_i18n::msg('ycom_fast_forward.config.default_ycom_group_id.none'), '0');
$select->addSqlOptions('SELECT id, name FROM ' . rex::getTable('ycom_group') . ' ORDER BY name ASC');

/* Passwortregeln */
$field = $form->addTextField('password_rules', null, ['class' => 'form-control']);
$field->setLabel(rex_i18n::msg('ycom_fast_forward.config.password_rules'));
$field->setNotice(rex_i18n::msg('ycom_fast_forward.config.password_rules.notice'));

/* Passwortregeln mit rex_form validieren */
$field->getValidator()->add('custom', rex_i18n::msg('ycom_fast_forward.config.password_rules.validate'), function ($value) {
    /* Überprüfen, ob JSON-Format */
    if (json_decode($value) === null) {
        return false;
    } 
    return true;
});


/* Textfeld zur Eingabe der Nutzungsbedingungen */

$field = $form->addTextAreaField('terms_of_use', null, ['class' => 'form-control']);
if (strval(rex_config::get('ycom_fast_forward', 'editor')) !== '') {
    $field->setAttribute('class', '###ycom_fast_forward-settings-editor###');
}
$field->setLabel(rex_i18n::msg('ycom_fast_forward.config.terms_of_use'));
$field->setNotice(rex_i18n::msg('ycom_fast_forward.config.terms_of_use.notice'));

/* WYSIWYG-Editor-Attribute für die Nutzungsbedingungen festlegen */

$field = $form->addTextField('editor', null, ['class' => 'form-control']);
$field->setLabel(rex_i18n::msg('ycom_fast_forward.config.editor'));
$field->setNotice(rex_i18n::msg('ycom_fast_forward.config.editor.notice'));


// Fieldset für Addon Mailer-Profile hinzufügen
$form->addFieldset(rex_i18n::msg('ycom_fast_forward.config.mailer_profiles'));

// Auswahl des gewünschten Mailer-Profiles, wenn das Addon installiert ist
$field = $form->addSelectField('mailer_profile_id', null, ['class' => 'form-control']);
$field->setLabel(rex_i18n::msg('ycom_fast_forward.config.mailer_profile'));
$field->setNotice(rex_i18n::msg('ycom_fast_forward.config.mailer_profile.notice'));

$select = $field->getSelect();
$select->setSize(1);
if (rex_addon::get('mailer_profile')->isAvailable()) {
    $options = rex_sql::factory()->setQuery('SELECT id, CONCAT(id, ": ",`fromname`) as `name` FROM ' . rex::getTable('mailer_profile') . ' ORDER BY name ASC');
    foreach ($options as $option) {
        $select->addOption($option->getValue('name'), $option->getValue('id'));
    }
} else {
    $select->addOption(rex_i18n::msg('ycom_fast_forward.config.mailer_profile.error'), '0');
}

// Formular ausgeben mit Core Section Fragment */

$fragment = new rex_fragment();
$fragment->setVar('class', 'edit', false);
$fragment->setVar('title', $addon->i18n('ycom_fast_forward.settings.title'), false);
$fragment->setVar('body', $form->get(), false);
echo $fragment->parse('core/page/section.php');
