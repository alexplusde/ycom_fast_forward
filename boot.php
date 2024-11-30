<?php

use Alexplusde\YComFastForward\YComFastForward;

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
