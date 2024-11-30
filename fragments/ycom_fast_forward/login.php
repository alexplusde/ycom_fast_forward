<?php

/** @var rex_fragment $this */

$title = $this->getVar('title', '');
$description = $this->getVar('description', '');

?>
<section class="container">
    <div class="row my-3">
        <div class="col-md-12">
        <?php if ('' !== $title) { ?>
				<div class="text-headline text-title col-md-12 my-2">
					<h1><?= $title ?></h1>
				</div>
			<?php } ?>
        </div>
    </div>
    <div class="row my-3">
        <div class="col-12 col-md-6">
        <?php if ('' !== $description) { ?>
				<div class="text-content col-md-12 my-2">
					<?= $description ?>
				</div>
			<?php } ?>
        </div>
        <div class="col-12 col-md-6">
            <?php
            $form = rex_yform::factory();

            $form->setValidateField('ycom_auth', ['login', 'password', null, '{{ycom_login_warning_enterloginpsw}}', 'Login fehlgeschlagen. Möglicherweise ist Ihr Account (noch) deaktiviert. Bitte setzen Sie sich persönlich mit uns in Verbindung, wenn das Problem weiterhin besteht.']);

            $form->setObjectparams('form_name', 'ycom_login');
            $form->setObjectparams('template', 'bootstrap5,bootstrap');
            $form->setObjectparams('form_action', rex_getUrl());

            $form->setValueField('text', ['login', '{{ycom_login_login}}', '', '', '{"required":"required","autocomplete":"email"}']);
            $form->setValidateField('empty', ['login', '{{ycom_login_warning_empty_login}}']);

            $form->setValueField('password', ['password', '{{ycom_login_password}}', '', '', '{"required":"required","autocomplete":"current-password"}']);
            $form->setValidateField('empty', ['password', '{{ycom_login_warning_empty_password}}']);

            $form->setValueField('ycom_auth_returnto', ['returnTo']);

            $form->setValueField('html', ['spacer', '<div class="my-3"></div>']);

            /* Submit-Button beschriften */
            $form->setValueField('submit', ['submit', '{{ycom_login_submit}}']);

            /* Passwort zurücksetzen verlinken */
            $form->setValueField('html', ['password_reset', '<a class="btn btn-link" href="' . rex_getUrl(rex_config::get('ycom/auth', 'article_id_password')) . '">{{ycom_login_password_reset}}</a>']);

            echo $form->getForm();
            ?>
        </div>
    </div>
</section>
