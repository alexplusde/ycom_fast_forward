<?php

namespace Alexplusde\YComFastForward;

use rex_article;
use rex_yrewrite;
use rex_yrewrite_domain;
use rex_yform_manager_dataset;

class Profile extends rex_yform_manager_dataset
{
    
    /* YRewrite Domain */
    /** @api */
    public function getYrewriteDomain() : ?rex_yrewrite_domain
    {
        return rex_yrewrite::getDomainById($this->getValue("yrewrite_domain_id"));
    }
    /** @api */
    public function getYrewriteDomainId() : ?int
    {
        return $this->getValue("yrewrite_domain_id");
    }
    /** @api */
    public function setYrewriteDomainId(int $value) : self
    {
        $this->setValue("yrewrite_domain_id", $value);
        return $this;
    }

    /* Login-Seite */
    /** @api */
    public function getArticleLogin() : ?rex_article
    {
        return rex_article::get($this->getValue("article_id_login"));
    }
    public function getArticleIdLogin() : ?int
    {
        return $this->getValue("article_id_login");
    }
    public function getArticleLoginUrl() : ?string
    {
        if ($article = $this->getArticleLogin()) {
            return $article->getUrl();
        }
    }
    /** @api */
    public function setArticleIdLogin(int $id) : self
    {
        if (rex_article::get($id)) {
            $this->getValue("article_id_login", $id);
        }
        return $this;
    }

    /* Logout-Seite */
    /** @api */
    public function getArticleLogout() : ?rex_article
    {
        return rex_article::get($this->getValue("article_id_logout"));
    }
    public function getArticleIdLogout() : ?int
    {
        return $this->getValue("article_id_logout");
    }
    public function getArticleIdLogoutUrl() : ?string
    {
        if ($article = $this->getArticleLogout()) {
            return $article->getUrl();
        }
    }
    /** @api */
    public function setArticleIdLogout(int $id) : self
    {
        if (rex_article::get($id)) {
            $this->getValue("article_id_logout", $id);
        }
        return $this;
    }

    /* Seite nach erfolgreicher Anmeldung */
    /** @api */
    public function getArticleJumpOk() : ?rex_article
    {
        return rex_article::get($this->getValue("article_id_jump_ok"));
    }
    public function getArticleIdJumpOk() : ?int
    {
        return $this->getValue("article_id_jump_ok");
    }
    public function getArticleIdJumpOkUrl() : ?string
    {
        if ($article = $this->getArticleJumpOk()) {
            return $article->getUrl();
        }
    }
    /** @api */
    public function setArticleIdJumpOk(int $id) : self
    {
        if (rex_article::get($id)) {
            $this->getValue("article_id_jump_ok", $id);
        }
        return $this;
    }

    /* Seite nach Abmeldung */
    /** @api */
    public function getArticleJumpLogout() : ?rex_article
    {
        return rex_article::get($this->getValue("article_id_jump_logout"));
    }
    public function getArticleIdJumpLogout() : ?int
    {
        return $this->getValue("article_id_jump_logout");
    }
    public function getArticleIdJumpLogoutUrl() : ?string
    {
        if ($article = $this->getArticleJumpLogout()) {
            return $article->getUrl();
        }
    }
    /** @api */
    public function setArticleIdJumpLogout(int $id) : self
    {
        if (rex_article::get($id)) {
            $this->getValue("article_id_jump_logout", $id);
        }
        return $this;
    }

    /* Seite bei Zugriffsverweigerung */
    /** @api */
    public function getArticleJumpDenied() : ?rex_article
    {
        return rex_article::get($this->getValue("article_id_jump_denied"));
    }
    public function getArticleIdJumpDenied() : ?int
    {
        return $this->getValue("article_id_jump_denied");
    }
    public function getArticleIdJumpDeniedUrl() : ?string
    {
        if ($article = $this->getArticleJumpDenied()) {
            return $article->getUrl();
        }
    }

    /** @api */
    public function setArticleIdJumpDenied(int $id) : self
    {
        if (rex_article::get($id)) {
            $this->getValue("article_id_jump_denied", $id);
        }
        return $this;
    }

    /* Passwort vergessen */
    /** @api */
    public function getArticlePassword() : ?rex_article
    {
        return rex_article::get($this->getValue("article_id_password"));
    }
    public function getArticleIdPassword() : ?int
    {
        return $this->getValue("article_id_password");
    }
    public function getArticleIdPasswordUrl() : ?string
    {
        if ($article = $this->getArticlePassword()) {
            return $article->getUrl();
        }
    }
    /** @api */
    public function setArticleIdPassword(int $id) : self
    {
        if (rex_article::get($id)) {
            $this->getValue("article_id_password", $id);
        }
        return $this;
    }

    /* Mailer-Profil */
    /** @api */
    public function getMailerProfile() : ?string
    {
        return $this->getValue("mailer_profile_id");
    }
    /** @api */
    public function setMailerProfileId(mixed $value) : self
    {
        $this->setValue("mailer_profile_id", $value);
        return $this;
    }

    /* E-Mail-Template für OTP */
    /** @api */
    public function getEmailTemplateOtp() : ?string
    {
        return $this->getValue("email_template_otp");
    }
    /** @api */
    public function setEmailTemplateOtp(mixed $value) : self
    {
        $this->setValue("email_template_otp", $value);
        return $this;
    }

    /* E-Mail-Template für Passwort */
    /** @api */
    public function getEmailTemplatePassword() : ?string
    {
        return $this->getValue("email_template_password");
    }
    /** @api */
    public function setEmailTemplatePassword(mixed $value) : self
    {
        $this->setValue("email_template_password", $value);
        return $this;
    }

    /* Dashboard-Seite */
    /** @api */
    public function getDashboardArticle() : ?rex_article
    {
        return rex_article::get($this->getValue("dashboard_article_id"));
    }
    public function getDashboardArticleId() : ?int
    {
        return $this->getValue("dashboard_article_id");
    }
    public function getDashboardArticleIdUrl() : ?string
    {
        if ($article = $this->getDashboardArticle()) {
            return $article->getUrl();
        }
    }
    /** @api */
    public function setDashboardArticleId(int $id) : self
    {
        if (rex_article::get($id)) {
            $this->getValue("dashboard_article_id", $id);
        }
        return $this;
    }

    /* Passwort zurücksetzen-Seite */
    /** @api */
    public function getResetpasswordArticle() : ?rex_article
    {
        return rex_article::get($this->getValue("resetpassword_article_id"));
    }
    public function getResetpasswordArticleId() : ?int
    {
        return $this->getValue("resetpassword_article_id");
    }
    public function getResetpasswordArticleIdUrl() : ?string
    {
        if ($article = $this->getResetpasswordArticle()) {
            return $article->getUrl();
        }
    }
    /** @api */
    public function setResetpasswordArticleId(int $id) : self
    {
        if (rex_article::get($id)) {
            $this->getValue("resetpassword_article_id", $id);
        }
        return $this;
    }

}
