<?php
/* YForm Model: YComFastForwardActivationKey */

namespace Alexplusde\YComFastForward;

use rex_ycom_user;
use rex_yform_manager_collection;
use rex_yform_manager_dataset;

class ActivationKey extends rex_yform_manager_dataset
{
    const STATUS_EXPIRED = -1;
    const STATUS_USED = 0;
    const STATUS_ACTIVE = 1;

    private static $status = [
        SELF::STATUS_EXPIRED => 'translate:rex_ycom_fast_forward_activation_key.status.expired',
        SELF::STATUS_USED => 'translate:rex_ycom_fast_forward_activation_key.status.used',
        SELF::STATUS_ACTIVE => 'translate:rex_ycom_fast_forward_activation_key.status.active',
    ];

    public static function getStatusAsChoiceArray() :array
    {
        return self::$status;
    }

    public static function findByKey($key) : self
    {
        return self::query()->where('activation_key', $key)->findOne();
    }

    public static function findByUserId($userId) :rex_yform_manager_collection
    {
        return self::query()->where('user_id', $userId)->find();
    }

    public static function new(int $userId) :self
    {
        $activationKey = self::create();
        $activationKey->setValue('ycom_user_id', $userId);
        $activationKey->setActivationKey(\bin2hex(\random_bytes(64)));
        $activationKey->setStatusActive();
        $activationKey->setCreatedate((new \DateTime())->format('Y-m-d H:i:s'));
        $activationKey->setUpdatedate((new \DateTime())->format('Y-m-d H:i:s'));
        $activationKey->setExpiredate((new \DateTime('+1 week'))->format('Y-m-d H:i:s'));
        $activationKey->setDeletedate((new \DateTime('+1 month'))->format('Y-m-d H:i:s'));
        if($activationKey->save()) {
            return $activationKey;
        }
        return null;
    }

    /* Aktivierungsstatus */
    public function isActive() :bool
    {
        // Expire-Datum ebenfalls auswerten
        if($this->getExpiredate() < new \DateTime()) {
            $this->setStatusExpired();
            return false;
        }
        return $this->getStatus() == 1;
    }

    public function setStatus(int $status) 
    {
        $this->setValue('status', $status);
        if($status == 1) {
            $this->setExpiredate(new \DateTime('+1 week'));
            $this->setDeletedate(new \DateTime('+1 month'));
        }
        if($status == 0) {
            // Expire-Date beibehalten
            $this->setUpdatedate((new \DateTime())->format('Y-m-d H:i:s'));
        }
        if($status == -1) {
            $this->setUpdatedate((new \DateTime())->format('Y-m-d H:i:s'));

        }

        return $this->save();
    }

    public function setStatusActive() :bool
    {
        $this->setValue('status', SELF::STATUS_ACTIVE);
        return($this->save());
    }

    public function setStatusUsed() :bool
    {
        $this->setStatus(SELF::STATUS_USED);
        return($this->save());
    }

    public function setStatusExpired() :bool
    {
        $this->setStatus(SELF::STATUS_EXPIRED);
        return($this->save());
    }

    /* YCom-User */
    /** @api */
    public function getYComUser() :? rex_ycom_user {
        return $this->getRelatedDataset("ycom_user_id");
    }

    /* Status */
    /** @api */
    public function getStatus() : mixed {
        return $this->getValue("status");
    }

    /* Aktivierungsschlüssel */
    /** @api */
    public function getActivationKey() : string {
        return $this->getValue("activation_key");
    }
    /** @api */
    public function setActivationKey(mixed $value) : self {
        $this->setValue("activation_key", $value);
        return $this;
    }

    /* Erstellt am... */
    /** @api */
    public function getCreatedate() : string {
        return $this->getValue("createdate");
    }
    /** @api */
    public function setCreatedate(string $value) : self {
        $this->setValue("createdate", $value);
        return $this;
    }

    /* Gültig bis... */
    /** @api */
    public function getExpiredate() : string {
        return $this->getValue("expiredate");
    }
    /** @api */
    public function setExpiredate(mixed $value) : self {
        $this->setValue("expiredate", $value);
        return $this;
    }

    /* Wird gelöscht am... */
    /** @api */
    public function getDeletedate() : string {
        return $this->getValue("deletedate");
    }
    /** @api */
    public function setDeletedate(mixed $value) : self {
        $this->setValue("deletedate", $value);
        return $this;
    }

    /* Zuletzt geändert am... */
    /** @api */
    public function getUpdatedate() : string {
        return $this->getValue("updatedate");
    }
    /** @api */
    public function setUpdatedate(string $value) : self {
        $this->setValue("updatedate", $value);
        return $this;
    }

    /* Notiz */
    /** @api */
    public function getComment() : string {
        return $this->getValue("comment");
    }
    /** @api */
    public function setComment(mixed $value) : self {
        $this->setValue("comment", $value);
        return $this;
    }

    /* Login as YCom User if Activation Key is valid and Key is not expired */
    public function login(bool $redirect = false) : bool
    {
        $ycom_user = $this->getYComUser();
        if($this->isActive() && $ycom_user) {
            if(\rex_ycom_auth::loginWithParams(['login' => $ycom_user->getId()]) !== false) {
                // Key invalidieren
                $this->setStatusUsed();
                // redirect zur Zielseite von YCom
                if($redirect) {
                    \rex_redirect(rex_getUrl(YComFastForward::getYComAuthConfig('article_id_login')));
                    exit;
                }
                return true;
            }
        }
        return false;
    }

    public function createTokenPerDomain() {
        $domains = \rex_yrewrite::getDomains();
        foreach ($domains as $domain) {
            // Token erzeugen
            $token = ActivationKey::new($this->getId());
            $token->setComment('Multi-Domain Temporary Access Token for ' . $domain->getName());
            $token->save();
        }
    }

}
