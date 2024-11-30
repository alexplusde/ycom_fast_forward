<?php

namespace Alexplusde\YComFastForward;

use rex_fragment;
use rex_config;
use rex_extension_point;
use rex_path;

class YComFastForward
{
    public static function parse(string $file, string $title = '', string $description = '')
    {
        $fragment = new rex_fragment();
        $fragment_path = rex_path::addon('ycom_fast_forward', 'fragments/ycom_fast_forward/' . $file);

        if (file_exists($fragment_path)) {
            $fragment->setVar('title', $title);
            $fragment->setVar('description', $description);
            return $fragment->parse('ycom_fast_forward'. \DIRECTORY_SEPARATOR . $file);
        }
    }

    public static function getConfig(string $key) :mixed
    {
        return rex_config::get('ycom_fast_forward', $key);
    }

    public static function setConfig(string $key, mixed $value) :bool
    {
        return rex_config::set('ycom_fast_forward', $key, $value);
    }

    /** @api */
    public static function getYComAuthConfig(string $key) :mixed
    {
        return rex_config::get('ycom/auth', $key);
    }

    /** @api */
    public static function setYComAuthConfig(string $key, mixed $value) :bool
    {
        return rex_config::set('ycom/auth', $key, $value);
    }

    /* Extension Point Funktionen */

    public static function CatAdded(rex_extension_point $ep) :void
    {
        $cat = $ep->getParam('category');
        $module_id = \rex_addon::get('ycom_fast_forward')->getProperty('module_id');


    }

    public static function artAdded(rex_extension_point $ep) :void
    {
        $art = $ep->getParam('article');
        $module_id = \rex_addon::get('ycom_fast_forward')->getProperty('module_id');

        if($art->getName() === 'Login') {
            // if (!rex_article_slice::getFirstSliceForArticle($id)) {
                \rex_content_service::addSlice($art->getId(), 1, 1, $module_id, [
                        'value10' => 'login.php'
                    ]);
            /// }
        }

        if($art->getName() === 'Logout') {
            // if (!rex_article_slice::getFirstSliceForArticle($id)) {
                \rex_content_service::addSlice($art->getId(), 1, 1, $module_id, [
                        'value10' => 'logout.php'
                    ]);
            // }
        }

        if($art->getName() === 'Passwort vergessen') {
            // if (!rex_article_slice::getFirstSliceForArticle($id)) {
                \rex_content_service::addSlice($art->getId(), 1, 1, $module_id, [
                        'value10' => 'password-2fa-check.php'
                    ]);
            // }
        }

        if($art->getName() === 'Passwort zurücksetzen') {
            // if (!rex_article_slice::getFirstSliceForArticle($id)) {
                \rex_content_service::addSlice($art->getId(), 1, 1, $module_id, [
                        'value10' => 'password-2fa-setup.php'
                    ]);
            // }
        }


        if($art->getName() === 'Mein Profil') {
            // if (!rex_article_slice::getFirstSliceForArticle($id)) {
                \rex_content_service::addSlice($art->getId(), 1, 1, $module_id, [
                        'value10' => 'profile.php'
                    ]);
            // }
        }

        if($art->getName() === 'Passwort ändern') {
            // if (!rex_article_slice::getFirstSliceForArticle($id)) {
                \rex_content_service::addSlice($art->getId(), 1, 1, $module_id, [
                        'value10' => 'password-change.php'
                    ]);
            // }
        }

        if($art->getName() === 'Passwort zurücksetzen') {
            // if (!rex_article_slice::getFirstSliceForArticle($id)) {
                \rex_content_service::addSlice($art->getId(), 1, 1, $module_id, [
                        'value10' => 'password-reset.php'
                    ]);
            // }
        }

        if($art->getName() === 'Registrierung') {
            // if (!rex_article_slice::getFirstSliceForArticle($id)) {
                \rex_content_service::addSlice($art->getId(), 1, 1, $module_id, [
                        'value10' => 'register.php'
                    ]);
            // }
        }

        if($art->getName() === 'Nutzungsbedingungen akzeptieren') {
            // if (!rex_article_slice::getFirstSliceForArticle($id)) {
                \rex_content_service::addSlice($art->getId(), 1, 1, $module_id, [
                        'value10' => 'terms_of_use.php'
                    ]);
            // }
        }

    }

}
