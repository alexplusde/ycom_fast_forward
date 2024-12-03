<?php

namespace Alexplusde\YComFastForward\Api;

use Alexplusde\YComFastForward\ActivationKey;

use rex_api_function;
use rex_response;
use rex_yrewrite;

class MultiLogin extends rex_api_function
{

    const url = '/index.php?rex-api-call=ycom_fast_forward_multi_login&token=XXX';

    public function execute()
    {
        header('Content-Type: application/json; charset=UTF-8');
        $ycom_user = \rex_ycom_auth::getUser();
        // Wenn get-Paramter "init" gesetzt ist, dann alle Domains mit allen Token als JSON ausgeben
        if ($ycom_user !== null && rex_request('init', 'int', 0) === 1) {
            $domains = rex_yrewrite::getDomains();
            $response = [];
            foreach ($domains as $domain) {
                $response[$domain] = ActivationKey::new($ycom_user->getId());
            }
            rex_response::setStatus(rex_response::HTTP_OK);
            echo json_encode($response);
            exit;
        }


        $token = rex_request('token', 'string', '');

        if (!$token) {
            rex_response::setStatus(rex_response::HTTP_FORBIDDEN);
            echo json_encode(['status' => 403, 'message' => 'Forbidden']);
            exit;
        }

        // Wenn bereits eingeloggt, dann ist die Aktion unnötig
        if ($ycom_user !== null) {
            rex_response::setStatus(rex_response::HTTP_OK);
            echo json_encode(['status' => 200, 'message' => 'Already logged in']);
            exit;
        }

        $activationKey = ActivationKey::findByKey($token);

        if (!$activationKey || !$activationKey->isActive()) {
            rex_response::setStatus(rex_response::HTTP_FORBIDDEN);
            echo json_encode(['status' => 403, 'message' => 'Forbidden']);
            exit;
        }

        if ($activationKey->login()) {
            $activationKey->setStatusExpired();
            rex_response::setStatus(rex_response::HTTP_OK);
            echo json_encode(['status' => 200, 'message' => 'Login successful']);
            exit;
        }

        rex_response::setStatus(rex_response::HTTP_FORBIDDEN);
        echo json_encode(['status' => 403, 'message' => 'Forbidden']);
        exit;
    }

}
