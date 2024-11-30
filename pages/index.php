<?php

/* Konfigurationsformular, um Einstellungen abzufragen: WYSIWYG-Editor Nutzungsbedingungen */

use Alexplusde\YComFastForward\YComFastForward;

$addon = rex_addon::get('ycom_fast_forward');

$form = new rex_config_form($addon->getName());

$form->addFieldset('translate:ycom_fast_forward_settings');

/* Textfeld zur Eingabe des Objparams für das gewünschte YForm Theme */

$field = $form->addTextField('yform_theme', null, ['class' => 'form-control']);
$field->setLabel('translate:ycom_fast_forward.config.yform_theme');
$field->setNotice('translate:ycom_fast_forward.config.yform_theme.notice');

$form->addFieldset('translate:ycom_fast_forward.terms_of_use');

/* Textfeld zur Eingabe der Nutzungsbedingungen */

$editor = YComFastForward::getConfig('editor');

$field = $form->addTextAreaField('terms_of_use', null, ['class' => 'form-control']);
if (strval(rex_config::get('ycom_fast_forward', 'editor')) !== '') { // @phpstan-ignore-line
    $field->setAttribute('class', '###ycom_fast_forward-settings-editor###');
}
$field->setLabel('translate:ycom_fast_forward.config.terms_of_use');
$field->setNotice('translate:ycom_fast_forward.config.terms_of_use.notice');

/* WYSIWYG-Editor-Attribute für die Nutzungsbedingungen festlegen */

$field = $form->addTextField('editor', null, ['class' => 'form-control']);
$field->setLabel('translate:ycom_fast_forward.config.editor');
$field->setNotice('translate:ycom_fast_forward.config.editor.notice');


echo $form->get();
