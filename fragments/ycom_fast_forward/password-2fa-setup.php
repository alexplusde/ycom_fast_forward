<?php

/** @var rex_fragment $this */

?>

<section class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Zwei-Faktor-Authentifizierung einrichten</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-6">
            <p></p>
        </div>
        <div class="col-12 col-md-6">
            <?php
            $yform = new rex_yform();
            $yform->setObjectparams('form_name', 'ycom_2fa_setup');
            $yform->setObjectparams('form_action', rex_getUrl('REX_ARTICLE_ID'));
            $yform->setObjectparams('form_ytemplate', 'bootstrap');
            $yform->setObjectparams('form_showformafterupdate', 0);
            $yform->setObjectparams('real_field_names', true);

            $yform->setValueField('ycom_auth_otp', ['setup']);

            echo $yform->getForm();

            ?>
        </div>
    </div>
</section>
