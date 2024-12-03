<?php

use Alexplusde\YComFastForward\ActivationKey;
use Alexplusde\YComFastForward\Api\MultiLogin;
/** @var rex_addon $this */

if (rex::isBackend()) {
    if ('ycom_fast_forward/settings' === rex_be_controller::getCurrentPage()) {
        rex_extension::register('OUTPUT_FILTER', static function (rex_extension_point $ep) {
            $suchmuster = 'class="###ycom_fast_forward-settings-editor###"';
            $ersetzen = strval(rex_config::get('ycom_fast_forward', 'editor'));
            $ep->setSubject(str_replace($suchmuster, $ersetzen, $ep->getSubject()));
        });
    }

}

if (rex_addon::get('yform')->isAvailable() && !rex::isSafeMode()) {
	rex_yform_manager_dataset::setModelClass(
		'rex_ycom_fast_forward_activation_key',
		ActivationKey::class, // Hier anpassen, falls Namespace verwendet wird
	);
}

rex_api_function::register('ycom_fast_forward_multi_login', MultiLogin::class);
