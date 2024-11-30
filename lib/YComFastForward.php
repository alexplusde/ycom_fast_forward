<?php

namespace Alexplusde\YComFastForward;

use rex_fragment;
use rex_config;
use rex_path;

class YComFastForward extends rex_fragment
{
    public function parse($file)
    {
        $fragment_path = rex_path::addon('ycom_fast_forward', 'fragments/ycom_fast_forward/' . $file);

        if (file_exists($fragment_path)) {
            return $this->subfragment($fragment_path);
        }
    }

    public static function getConfig($key)
    {
        return rex_config::get('ycom_fast_forward', $key);
    }

    public static function setConfig($key, $value)
    {
        return rex_config::set('ycom_fast_forward', $key, $value);
    }

    public static function getYComAuthConfig($key)
    {
        return rex_config::get('ycom/auth', $key);
    }

    public static function setYComAuthConfig($key, $value)
    {
        return rex_config::set('ycom/auth', $key, $value);
    }
}
