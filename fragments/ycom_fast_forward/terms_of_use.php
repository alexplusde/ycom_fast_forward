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
        <div class="col-12">
            <p><?= $description ?></p>
        </div>

        <div class="col-12">

            <?php

            $ycom_user = \rex_ycom_auth::getUser();

            if($ycom_user !== null) {
                $ycom_user_id = $ycom_user->getId();
                rex_set_session('ycom_user_id', $ycom_user_id);
            } else {
                $ycom_user_id = rex_session('ycom_user_id', 'int');
            }

            $yform = new rex_yform();
            $yform->setObjectparams('form_name', 'ycom_termsofuse');
            $yform->setObjectparams('form_action', rex_getUrl('REX_ARTICLE_ID'));
            $yform->setObjectparams('form_ytemplate', 'bootstrap5,bootstrap');
            $yform->setObjectparams('form_showformafterupdate', 1);
            $yform->setObjectparams('real_field_names', true);
            
            $yform->setObjectparams('getdata',1);
            $yform->setObjectparams('main_where','id='.$ycom_user_id);
            $yform->setObjectparams('main_table','rex_ycom_user');

            $yform->setValueField('showvalue', ['email', "E-Mail-Adresse / Login"]);

            $yform->setValueField('html', [YComFastForward::getConfig('terms_of_use')]);

            $yform->setValueField('checkbox', ['termsofuse_accepted', '{{ycom_user_termsofuse_accepted}}', '', '', '{"required":"required"}']);
            $yform->setValidateField('empty', ['termsofuse_accepted', '{{ycom_user_please_accept_termsofuse}}']);

            $yform->setActionField('db', ['rex_ycom_user', 'main_where']);
            // $yform->setActionField('ycom_auth_db', ['update']);

            $yform->setActionField('redirect', [rex_config::get('ycom/auth', 'article_id_jump_ok')]);

            echo $yform->getForm();

            ?>
        </div>
    </div>
</section>
