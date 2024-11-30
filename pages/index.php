<?php

/* Konfigurationsformular, um Einstellungen abzufragen: WYSIWYG-Editor Nutzungsbedingungen */
$addon = rex_addon::get('ycom_fast_forward');

$form = new rex_config_form($addon->getName());

$form->addFieldset('translate:ycom_fast_forward_settings');

$field = $form->addTextAreaField('terms_of_use', null, ['class' => 'form-control']);
$field->setLabel('translate:ycom_fast_forward.config.terms_of_use');
$field->setNotice('translate:ycom_fast_forward.config.terms_of_use.notice');

echo $form->get();
