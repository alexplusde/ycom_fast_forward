<?php

/* Konfigurationsformular, um Einstellungen abzufragen: WYSIWYG-Editor Nutzungsbedingungen */

use Alexplusde\YComFastForward\YComFastForward;

/* Titel ausgeben */
echo rex_view::title(rex_i18n::msg('ycom_fast_forward.title'));

$addon = rex_addon::get('ycom_fast_forward');

$form = rex_config_form::factory($addon->getName());

$form->addFieldset(rex_i18n::msg('ycom_fast_forward.settings.title'));

/* Textfeld zur Eingabe des Objparams für das gewünschte YForm Theme */

$field = $form->addTextField('yform_theme', null, ['class' => 'form-control']);
$field->setLabel(rex_i18n::msg('ycom_fast_forward.config.yform_theme'));
$field->setNotice(rex_i18n::msg('ycom_fast_forward.config.yform_theme.notice'));

$form->addFieldset(rex_i18n::msg('ycom_fast_forward.config.terms_of_use'));

/* Textfeld zur Eingabe der Nutzungsbedingungen */

$editor = YComFastForward::getConfig('editor');

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

// Formular ausgeben mit Core Section Fragment */

$fragment = new rex_fragment();
$fragment->setVar('class', 'edit', false);
$fragment->setVar('title', $addon->i18n('ycom_fast_forward.settings.title'), false);
$fragment->setVar('body', $form->get(), false);
echo $fragment->parse('core/page/section.php');
