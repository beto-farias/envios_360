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

        //Validacion de entrada
        $error = new MessageResponse();
        if(!$this->validateRequiredParam($error,isset($GLOBALS["HTTP_RAW_POST_DATA"]), "Raw Data" )){
            return $error;
        }

        $json = json_decode($GLOBALS["HTTP_RAW_POST_DATA"] );
        
        if(!$this->validateRequiredParam($error,isset($json->shiper->postal_code), "Shipper CP" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->recipient->postal_code), "Recipient CP" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->package->peso_kg), "Peso en kg" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->package->largo_cm), "Largo CM" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->package->ancho_cm), "Ancho CM" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->package->alto_cm), "Alto CM" )){
            return $error;
        }


        $path_to_wsdl = Yii::getAlias('@app') . '/vendor/shipment-carriers/estafeta/wsdl/Frecuenciacotizador.wsdl';
        ini_set("soap.wsdl_cache_enabled", "0");

        $client = new \SoapClient($path_to_wsdl, array('trace' => 1));

        $request = [];
        $request['idusuario'] = $this::ID_USUARIO;
        $request['usuario'] = $this::USUARIO;
        $request['contra'] = $this::PASSWORD;
        $request['esFrecuencia'] = false;
        $request['esLista'] = true;
        
        $request['tipoEnvio']['EsPaquete'] = true;
        $request['tipoEnvio']['Largo'] = $json->package->largo_cm;
        $request['tipoEnvio']['Peso'] = $json->package->peso_kg;
        $request['tipoEnvio']['Alto'] = $json->package->alto_cm;
        $request['tipoEnvio']['Ancho'] = $json->package->ancho_cm;

        $request['datosOrigen'] = [];
        $request['datosOrigen']['string'] = $json->shiper->postal_code;
        
        $request['datosDestino'] = [];
        $request['datosDestino']['string'] = $json->recipient->postal_code;
        


        $response = $client->FrecuenciaCotizador($request);

        return $response;
    }




    private function validateRequiredParam($response, $isSet, $atributoName){
        if(!$isSet){
            $response->responseCode = -1;
            $response->message = $atributoName . ' faltante';
            return false;
        }
        return true;
    }

}
