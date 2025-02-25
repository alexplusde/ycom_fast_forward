<?php

/** @var rex_fragment $this */

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
            <?= $description ?>
        </div>
        <div class="col-12 col-md-9">
            <?php

            $yform = new rex_yform();
            $yform->setObjectparams('form_name', 'ycom_profile');
            $yform->setObjectparams('form_action', rex_getUrl('REX_ARTICLE_ID'));
            $yform->setObjectparams('form_ytemplate', 'bootstrap5,bootstrap');
            $yform->setObjectparams('form_showformafterupdate', 1);
            $yform->setObjectparams('real_field_names', true);

            $yform->setValueField('ycom_auth_load_user', ['userinfo', 'email,firstname,lastname']);

            /* Erfolgsmeldung */
            $yform->setActionField('showtext', ['{{ycom_user_form_confirm_message}}', '<p class="alert alert-success">', '</p>']);

            /* Eigentliches Formular */
            $yform->setValueField('showvalue', ['email', '{{ycom_user_email}}']);
            $yform->setValueField('text', ['firstname', '{{ycom_user_firstname}}']);
            $yform->setValueField('text', ['lastname', '{{ycom_user_lastname}}']);

            $yform->setValueField('checkbox', ['has_newsletter_consented', '{{ycom_user_has_newsletter_consented}}', '0', '0', '', '', ',📧']);

            $yform->setActionField('copy_value', ['email', 'login']);

            $yform->setActionField('ycom_auth_db', []);

            echo $yform->getForm();
            ?>

        </div>
    </div>
</section>
