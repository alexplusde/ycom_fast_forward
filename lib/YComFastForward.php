<?php

namespace Alexplusde\YComFastForward;

use rex_fragment;
use rex_config;
use rex_extension_point;
use rex_path;

class YComFastForward
{
    /** @api */
    public static function parse(string $file, string $title = '', string $description = '')
    {
        $fragment = new rex_fragment();
        $fragment_path = rex_path::addon('ycom_fast_forward', 'fragments/ycom_fast_forward/' . $file);

        if (file_exists($fragment_path)) {
            $fragment->setVar('title', $title);
            $fragment->setVar('description', $description, false);
            return $fragment->parse('ycom_fast_forward' . \DIRECTORY_SEPARATOR . $file);
        }
    }

    /** @api */
    public static function getConfig(string $key): mixed
    {
        return rex_config::get('ycom_fast_forward', $key);
    }

    /** @api */
    public static function setConfig(string $key, mixed $value): bool
    {
        return rex_config::set('ycom_fast_forward', $key, $value);
    }

    /** @api */
    public static function getYComAuthConfig(string $key): mixed
    {
        return rex_config::get('ycom/auth', $key);
    }

    /** @api */
    public static function setYComAuthConfig(string $key, mixed $value): bool
    {
        return rex_config::set('ycom/auth', $key, $value);
    }

    public static function setYcomAuthForArticle(int $article_id, int $auth_type = 0): void
    {
        \rex_sql::factory()->setTable(\rex::getTable('article'))
            ->setWhere('id = :pid', ['id' => $article_id])
            ->setValue('ycom_auth_type', $auth_type)
            ->update();
    }

    /* Extension Point Funktionen */
    /** @api */
    public static function CatAdded(rex_extension_point $ep): void
    {
        $cat = \rex_category::get($ep->getParam('id'));

        if($cat->getName() == 'Login') {
            // ID in Property merken
            \rex_addon::get('ycom_fast_forward')->setProperty('category_id_login', $cat->getId());
        }

        if($cat->getName() == 'Mein Profil') {

            \rex_addon::get('ycom_fast_forward')->setProperty('category_id_myprofile', $cat->getId());
        }


    }

    /** @api */
    public static function artAdded(rex_extension_point $ep): void
    {
        $art = \rex_article::get($ep->getParam('id'));

        $module_id = (int) \rex_addon::get('ycom_fast_forward')->getProperty('module_id');



        if ($art->getName() === 'Login') {

            \rex_content_service::addSlice($art->getId(), 1, 1, $module_id, [
                'value1' => 'Login',
                'value2' => '<p>Loggen Sie sich ein.</p>',
                'value10' => 'login.php'
            ]);
            /// }

            // YCom-Auth Config setzen
            self::setYComAuthConfig('article_id_login', $art->getId());
        }

        if ($art->getName() === 'Logout') {

            \rex_content_service::addSlice($art->getId(), 1, 1, $module_id, [
                'value1' => 'Login',
                'value2' => '<p>Loggen Sie sich ein.</p>',
                'value10' => 'logout.php'
            ]);

            // YCom-Auth Config setzen
            self::setYComAuthConfig('article_id_logout', $art->getId());
        }

        if ($art->getName() === 'Passwort vergessen') {

            \rex_content_service::addSlice($art->getId(), 1, 1, $module_id, [
                'value1' => 'Login',
                'value2' => '<p>Loggen Sie sich ein.</p>',
                'value10' => 'password-2fa-check.php'
            ]);
        }

        if ($art->getName() === 'Passwort zurücksetzen') {

            \rex_content_service::addSlice($art->getId(), 1, 1, $module_id, [
                'value1' => 'Login',
                'value2' => '<p>Loggen Sie sich ein.</p>',
                'value10' => 'password-2fa-setup.php'
            ]);
        }


        if ($art->getName() === 'Mein Profil') {

            \rex_content_service::addSlice($art->getId(), 1, 1, $module_id, [
                'value1' => 'Mein Profil',
                'value2' => '<p>Bearbeiten Sie Ihr Profil.</p>',
                'value10' => 'profile.php'
            ]);
        }

        if ($art->getName() === 'Passwort ändern') {

            \rex_content_service::addSlice($art->getId(), 1, 1, $module_id, [
                'value1' => 'Mein Profil',
                'value2' => '<p>Bearbeiten Sie Ihr Profil.</p>',
                'value10' => 'password-change.php'
            ]);
        }

        if ($art->getName() === 'Passwort zurücksetzen') {

            \rex_content_service::addSlice($art->getId(), 1, 1, $module_id, [
                'value1' => 'Mein Profil',
                'value2' => '<p>Bearbeiten Sie Ihr Profil.</p>',
                'value10' => 'password-reset.php'
            ]);
        }

        if ($art->getName() === 'Registrierung') {

            \rex_content_service::addSlice($art->getId(), 1, 1, $module_id, [
                'value1' => 'Mein Profil',
                'value2' => '<p>Bearbeiten Sie Ihr Profil.</p>',
                'value10' => 'register.php'
            ]);

            rex_config::set('ycom', 'article_id_register', $art->getId());
        }

        if ($art->getName() === 'Nutzungsbedingungen akzeptieren') {

            \rex_content_service::addSlice($art->getId(), 1, 1, $module_id, [
                'value1' => 'Mein Profil',
                'value2' => '<p>Bearbeiten Sie Ihr Profil.</p>',
                'value10' => 'terms_of_use.php'
            ]);

            rex_config::set('ycom', 'article_id_jump_termsofuse', $art->getId());
        }

        if ($art->getName() === 'OTP-Verifizierung') {

            \rex_content_service::addSlice($art->getId(), 1, 1, $module_id, [
                'value1' => 'Mein Profil',
                'value2' => '<p>Bearbeiten Sie Ihr Profil.</p>',
                'value10' => 'otp-verify.php'
            ]);

            rex_config::set('ycom', 'otp_article_id', $art->getId());
        }
    }
}
