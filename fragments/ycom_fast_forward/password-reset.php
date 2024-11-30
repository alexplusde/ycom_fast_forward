<?php

/** @var rex_fragment $this */

use Alexplusde\YComFastForward\YComFastForward;

?>
<section class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Passwort zurücksetzen</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-6">
            <p>Bitte geben Sie Ihre E-Mail-Adresse ein, um das Passwort zurückzusetzen.</p>
        </div>
        <div class="col-12 col-md-6">
            <?php
            $yform = new rex_yform();
            $yform->setObjectparams('form_name', 'ycom_password_reset');
            $yform->setObjectparams('form_action', rex_getUrl('REX_ARTICLE_ID'));
            $yform->setObjectparams('form_ytemplate', 'bootstrap5,bootstrap');
            $yform->setObjectparams('form_showformafterupdate', 0);
            $yform->setObjectparams('real_field_names', true);

            $yform->setValueField('text', ['email', '{{ycom_user_email}}']);
            $yform->setValidateField('empty', ['email', '{{ycom_user_email_empty}}']);
            $yform->setValidateField('type', ['email', 'email', '{{ycom_user_email_invalid}}']);
            $yform->setValidateField('in_table', ['email', 'rex_ycom_user', 'email', '{{ycom_user_email_not_found}}']);
            $yform->setValueField('generate_key', ['activation_key', '{{ycom_user_activation_key}}']);
            $yform->setActionField('db_query', ['update rex_ycom_user set activation_key = ? where email = ?', 'activation_key,email']);

            // Wenn Mailer-Profile installiert ist und ein abweichendes Profil definiert ist, dann dieses verwenden
            $mailer_profile_id = YComFastForward::getConfig('mailer_profile_id');
            if (rex_addon::get('mailer_profile')->isAvailable() && $mailer_profile_id > 0) {
                $yform->setActionField('mailer_profile', [$mailer_profile_id]);
            }

            $yform->setActionField('tpl2email', ['resetpassword_de', 'email']);
            $yform->setActionField('showtext', ['{{ycom_user_password_reset_message}}', '<p class="alert alert-info">', '</p>', '1']);

            echo $yform->getForm();
            ?>
        </div>
    </div>
</section>
