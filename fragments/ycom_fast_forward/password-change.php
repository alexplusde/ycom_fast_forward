<?php

/** @var rex_fragment $this */

use Alexplusde\YComFastForward\YComFastForward;

$title = $this->getVar('title', '');
$description = $this->getVar('description', '');
?>
<section class="container">
    <div class="row">
    <div class="col-md-12">
            <h1><?= $title ?></h1>
        </div>
        <div class="col-md-12">
            <h1><?= $description ?></h1>
        </div>
    </div>
    <div class="row">
    <div class="col-12 col-md-3">
        </div>
        <div class="col-12 col-md-9">
            <?php
            $yform = new rex_yform();
            $yform->setObjectparams('form_name', 'ycom_password_change');
            $yform->setObjectparams('form_action', rex_getUrl('REX_ARTICLE_ID'));
            $yform->setObjectparams('form_ytemplate', 'bootstrap5,bootstrap');
            $yform->setObjectparams('form_showformafterupdate', 0);
            $yform->setObjectparams('real_field_names', true);
            $yform->setValueField('password', ['old_password', '{{ycom_user_old_password}}']);

            /* Passwort-Regeln aus Einstellungen übernehmen */
            $password_rule = YComFastForward::getConfig('password_rules');
            if($password_rule !== "") {
                $yform->setValueField('ycom_auth_password', ['password', '{{ycom_user_password}}', $password_rule, '{{ycom_user_password_validation_message}}']);
            } else {
                $yform->setValueField('ycom_auth_password', ['password', '{{ycom_user_password}}', '{"length":{"min":16},"letter":{"min":1},"lowercase":{"min":0},"uppercase":{"min":0},"digit":{"min":1},"symbol":{"min":0}}', '{{ycom_user_password_validation_message}}']);
            }
            $yform->setValueField('password', ['password_2', '{{ycom_user_password_repeat}}']);

            $yform->setValidateField('empty', ['old_password', '{{ycom_user_old_password_required}}']);
            $yform->setValidateField('ycom_auth_password', ['old_password', '{{ycom_user_old_password_invalid}}']);
            $yform->setValidateField('compare', ['password', 'old_password', '==', '{{ycom_user_password_same_as_old}}']);
            $yform->setValidateField('empty', ['password', '{{ycom_user_password_required}}']);
            $yform->setValidateField('compare', ['password', 'password_2', '!=', '{{ycom_user_password_mismatch}}']);
            $yform->setActionField('showtext', ['{{ycom_user_password_updated}}', '', '', '1']);
            $yform->setActionField('ycom_auth_db');
            $yform->setValueField('hidden', ['new_password_required', '0']);

            echo $yform->getForm();

            ?>
        </div>
    </div>
</section>
