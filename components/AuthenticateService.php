<?php
namespace app\components;

use Yii;
use yii\filters\AccessControl;

class AuthenticateService {

    /**
     * Verifica si el usuario cuenta ya con un token de seguridad valido
     */
    public function beforeAction($action)
    {
        $tokenValue = $_SERVER['HTTP_AUTHENTICATION-TOKEN'];

        echo $tokenValue;
    }

}