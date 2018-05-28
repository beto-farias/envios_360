<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\components\AccessControlExtend;
use yii\helpers\Json;
use app\models\MessageResponse;



class EstafetaServicesController extends \yii\rest\Controller{

    const ID_USUARIO = 1;
    const USUARIO = 'AdminUser';
    const PASSWORD = ',1,B(vVi';


    public $enableCsrfValidation = false;
    public $layout = null;


    // -------------- CONSTANTES -----------------------------------------

    const APPI_VERSION = "1.0.0";
    

    const LIST_PAGE_SIZE = 100;
    const LIST_PAGE_NUMBER = 1;



    public function init(){
        parent::init();  
        //Asegura que las fechas sean las de la cd de mexico      
        date_default_timezone_set('America/Mexico_City');
    }
    
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Max-Age' => 86400,
            ],
        ];
        return $behaviors;
    }

    public function actionFrecuenciaCotizador(){
        $path_to_wsdl = Yii::getAlias('@app') . '/vendor/shipment-carriers/estafeta/wsdl/Frecuenciacotizador.wsdl';
        ini_set("soap.wsdl_cache_enabled", "0");

        $client = new \SoapClient($path_to_wsdl, array('trace' => 1));
        $request = $this->getClientRequest();
    }

}
