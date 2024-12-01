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

    public static function resetYComUserTermsOfUseAccepted(): void
    {
        $users = \rex_ycom_user::query()->find();
        $users->setValue('termsofuse_accepted', 0);
        $users->save();

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
                'value2' => '<p>Loggen Sie sich ein. Wenn Sie Ihre Zugangsdaten nicht mehr haben, können Sie auch Ihr Passwort zurücksetzen. Für alle anderen Probleme, wenden Sie sich bitte direkt an uns.</p>',
                'value10' => 'login.php'
            ]);
            /// }

            // YCom-Auth Config setzen
            self::setYComAuthConfig('article_id_login', $art->getId());
        }

        if ($art->getName() === 'Logout') {

            \rex_content_service::addSlice($art->getId(), 1, 1, $module_id, [
                'value1' => 'Logout',
                'value2' => '<p></p>',
                'value10' => 'logout.php'
            ]);

            // YCom-Auth Config setzen
            self::setYComAuthConfig('article_id_logout', $art->getId());
        }

        if ($art->getName() === 'Passwort vergessen') {

            \rex_content_service::addSlice($art->getId(), 1, 1, $module_id, [
                'value1' => 'Passwort vergessen',
                'value2' => '<p>Wenn Sie Ihr Passwort vergessen haben, können Sie hier das Passwort zurücksetzen. Sie erhalten an die bei uns hinterlegte E-Mail-Adresse eine Mail mit einem Link.</p><p>Im Anschluss können Sie das Passwort zurücksetzen.</p>',
                'value10' => 'password-2fa-check.php'
            ]);

            // YCom-Auth Config setzen
            self::setYComAuthConfig('article_id_password', $art->getId());
        }

        if ($art->getName() === 'Passwort zurücksetzen') {

            \rex_content_service::addSlice($art->getId(), 1, 1, $module_id, [
                'value1' => 'Passwort zurücksetzen',
                'value2' => '<p>Setzen Sie Ihr Passwort zurück. Verwenden Sie ein Passwort, das Sie sonst nicht benutzen.</p>',
                'value10' => 'password-2fa-setup.php'
            ]);

            // YCom-Auth Config setzen
            self::setYComAuthConfig('otp_article_id', $art->getId());
        }


        if ($art->getName() === 'Mein Profil') {

            \rex_content_service::addSlice($art->getId(), 1, 1, $module_id, [
                'value1' => 'Mein Profil',
                'value2' => '<p>Hier können Sie die bei uns hinterlegten Informationen korrigieren.</p>',
                'value10' => 'profile.php'
            ]);

        }

        if ($art->getName() === 'Passwort ändern') {

            \rex_content_service::addSlice($art->getId(), 1, 1, $module_id, [
                'value1' => 'Passwort ändern',
                'value2' => '<p>Achten Sie darauf, ein Passwort zu verwenden, das Sie sonst nirgendwo benutzen.</p>',
                'value10' => 'password-change.php'
            ]);

        }

        if ($art->getName() === 'Passwort zurücksetzen') {

            \rex_content_service::addSlice($art->getId(), 1, 1, $module_id, [
                'value1' => 'Mein Profil',
                'value2' => '<p>Bearbeiten Sie Ihr Profil.</p>',
                'value10' => 'password-reset.php'
            ]);

            // YCom-Auth Config setzen
            self::setYComAuthConfig('article_id_password', $art->getId());
        }

        if ($art->getName() === 'Registrierung') {

            \rex_content_service::addSlice($art->getId(), 1, 1, $module_id, [
                'value1' => 'Registreirung',
                'value2' => '<p>Füllen Sie das Formular aus, um fortzufahren.</p>',
                'value10' => 'register.php'
            ]);

            rex_config::set('ycom', 'article_id_register', $art->getId());
        }

        if ($art->getName() === 'Nutzungsbedingungen akzeptieren') {

            \rex_content_service::addSlice($art->getId(), 1, 1, $module_id, [
                'value1' => 'Nutzungsbedingungen akzeptieren',
                'value2' => '<p>In unseren Nutzungsbedingungen wird beschrieben, wie Sie unseren geschützten Bereich verwenden dürfen.</p>',
                'value10' => 'terms_of_use.php'
            ]);

            rex_config::set('ycom', 'article_id_jump_termsofuse', $art->getId());
        }

        if ($art->getName() === 'OTP-Verifizierung') {

            \rex_content_service::addSlice($art->getId(), 1, 1, $module_id, [
                'value1' => 'OTP-Verifizierung',
                'value2' => '<p>Verwenden Sie unsere 2-Faktor-Authentifzierung, um Ihr Konto zu schützen.</p>',
                'value10' => 'otp-verify.php'
            ]);

            rex_config::set('ycom', 'otp_article_id', $art->getId());
        }
    }
}
