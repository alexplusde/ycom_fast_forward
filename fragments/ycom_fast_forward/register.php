<?php

/** @var rex_fragment $this */

use Alexplusde\YComFastForward\YComFastForward;

$title = $this->getVar('title', '');
$description = $this->getVar('description', '');

?>
<section class="container">
    <div class="row my-3">
        <div class="col-md-12">
            <h1><?= $title ?></h1>
        </div>
    </div>
    <div class="row my-3">
        <div class="col-12 col-md-6">
            <p><?= $description ?></p>
        </div>
        <div class="col-12 col-md-6">
            <?php
            $yform = new rex_yform();
            $yform->setObjectparams('form_name', 'ycom_register');
            $yform->setObjectparams('form_action', rex_getUrl('REX_ARTICLE_ID'));
            $yform->setObjectparams('form_ytemplate', 'bootstrap5,bootstrap');
            $yform->setObjectparams('form_showformafterupdate', 0);
            $yform->setObjectparams('real_field_names', true);

            /* Status aus rex_config laden */
            $status = YComFastForward::getConfig('ycom_user_default_status');
            $yform->setValueField('hidden', ['status', $status]);

            /* YCom-Gruppe aus rex_config laden */
            $default_ycom_group_id = YComFastForward::getConfig('default_ycom_group_id');
            if($default_ycom_group_id > 0) {
                $yform->setValueField('hidden', ['ycom_group_id', $default_ycom_group_id]);
            }

            /* Vorname und Nachname */
            $yform->setValidateField('empty', ['firstname', '{{ycom_user_please_enter_firstname}}']);
            $yform->setValidateField('empty', ['lastname', '{{ycom_user_please_enter_lastname}}']);

            /* E-Mail */
            $yform->setValueField('text', ['email', '{{ycom_user_email}}', '', '', '{"required":"required"}']);
            $yform->setValueField('text', ['email_2', '{{ycom_user_email_2}}', '', 'no_db']);

            $yform->setValidateField('empty', ['email', '{{ycom_user_please_enter_email}}']);
            $yform->setValidateField('type', ['email', 'email', '{{ycom_user_please_enter_email}}']);
            $yform->setValidateField('unique', ['email', '{{ycom_user_this_email_exists_already}}', 'rex_ycom_user']);
            $yform->setValidateField('empty', ['email_2', '{{ycom_user_please_enter_email}}']);
            $yform->setValidateField('type', ['email_2', 'email', '{{ycom_user_please_enter_email}}']);
            $yform->setValidateField('compare', ['email', 'email_2', '{{ycom_user_please_enter_email_twice}}']);

            /* Login befüllen */
            $yform->setActionField('copy_value', ['email', 'login']);

            /* Passwort */
            
            /* Passwort-Regeln aus Einstellungen übernehmen */
            $password_rule = YComFastForward::getConfig('password_rules');
            if($password_rule !== "") {
                $yform->setValueField('ycom_auth_password', ['password', '{{ycom_user_password}}', $password_rule, '{{ycom_user_password_validation_message}}']);
            } else {
                $yform->setValueField('ycom_auth_password', ['password', '{{ycom_user_password}}', '{"length":{"min":16},"letter":{"min":1},"lowercase":{"min":0},"uppercase":{"min":0},"digit":{"min":1},"symbol":{"min":0}}', '{{ycom_user_password_validation_message}}']);
            }
 
            $yform->setValueField('text', ['password_confirm', '{{ycom_user_password_confirm}}', '', 'no_db', '{"required":"required"}']);
            $yform->setValidateField('empty', ['password', '{{ycom_user_please_enter_password}}', '', null, '{"required":"required"}']);
            $yform->setValidateField('empty', ['password_confirm', '{{ycom_user_please_enter_password}}', '', 'no_db']);
            $yform->setValidateField('compare', ['password', 'password_confirm', '{{ycom_user_please_enter_password_twice}}']);

            /* Nutzungsbedingungen akzeptieren */
            $yform->setValueField('checkbox', ['termsofuse_accepted', '{{ycom_user_termsofuse_accepted}}', '', '', '{"required":"required"}']);
            $yform->setValidateField('empty', ['termsofuse_accepted', '{{ycom_user_please_accept_termsofuse}}']);

            /* Activation-Key erstellen und versenden */
            $yform->setValueField('generate_key', ['activation_key', '{{ycom_user_activation_key}}', '0', '0']);
            $yform->setValidateField('unique', ['activation_key', '{{ycom_user_this_activation_key_exists_already}}', 'rex_ycom_user', '0']);
            $yform->setActionField('tpl2email', ['ycom_access_request_de', 'email', 'ycom_access_request_email_subject', 'ycom_access_request_email_body', '0', '0', '0']);
            /* In Datenbank erstellen */
            $yform->setActionField('db', ['rex_ycom_user']);

            /* Erfolgsmeldung ausgeben */
            $yform->setActionField('showtext', ['{{ycom_user_registration_successful}}', '<p class="alert alert-success">', '</p>']);

            echo $yform->getForm();
            ?>
        </div>
    </div>
</section>
