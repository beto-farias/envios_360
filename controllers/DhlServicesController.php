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



class DhlServicesController extends \yii\rest\Controller{

    const ID_USUARIO = 1;
    const USUARIO = 'AdminUser';
    const PASSWORD = ',1,B(vVi';


    public $enableCsrfValidation = false;
    public $layout = null;


    // -------------- CONSTANTES -----------------------------------------

    const APPI_VERSION = "1.0.0";
    

    const LIST_PAGE_SIZE = 100;
    const LIST_PAGE_NUMBER = 1;

    const URL_DEV  = 'https://wwwcie.ups.com/rest/';
    const URL_PROD = 'https://onlinetools.ups.com/rest/';

    var $URL_SERVICE = '';


    public function init(){
        parent::init();  
        //Asegura que las fechas sean las de la cd de mexico      
        date_default_timezone_set('America/Mexico_City');

        $this->URL_SERVICE = $this::URL_DEV;
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

    /**
     * Servicio para realizar el envio, genera la etiqueta
     */
    public function actionShipService(){
        //Validacion de entrada
        $error = new MessageResponse();
        if(!$this->validateRequiredParam($error,isset($GLOBALS["HTTP_RAW_POST_DATA"]), "Raw Data" )){
            return $error;
        }

        $json = json_decode($GLOBALS["HTTP_RAW_POST_DATA"] );

        if(!$this->validateRequiredParam($error,isset($json->service_type), "Service type" )){
            return $error;
        }

        
        if(!$this->validateRequiredParam($error,isset($json->shiper->postal_code), "Shipper CP" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->shiper->city), "Shipper Country code" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->shiper->state_code), "Shipper State code" )){
            return $error;
        }
        if(!$this->validateRequiredParam($error,isset($json->shiper->person_name), "Shipper Person name" )){
            return $error;
        }
        if(!$this->validateRequiredParam($error,isset($json->shiper->phone_number), "Shipper Phone number" )){
            return $error;
        }
        if(!$this->validateRequiredParam($error,isset($json->shiper->address_line), "Shipper Address line" )){
            return $error;
        }
        if(!$this->validateRequiredParam($error,isset($json->shiper->company_name), "Shipper Company name" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->recipient->postal_code), "Recipient CP" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->recipient->country_code), "Recipient Country code" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->recipient->city), "Recipient Country code" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->recipient->state_code), "Recipient State code" )){
            return $error;
        }
        if(!$this->validateRequiredParam($error,isset($json->recipient->person_name), "Recipient Person name" )){
            return $error;
        }
        if(!$this->validateRequiredParam($error,isset($json->recipient->phone_number), "Recipient Phone number" )){
            return $error;
        }
        if(!$this->validateRequiredParam($error,isset($json->recipient->address_line), "Recipient Address line" )){
            return $error;
        }
        if(!$this->validateRequiredParam($error,isset($json->recipient->company_name), "Recipient Company name" )){
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

        if(!$this->validateRequiredParam($error,isset($json->service_packing), "Service Packing" )){
            return $error;
        }

        return $this->getErrorResponse(-1,"Método no implementado");
        
    }


    



    public function actionRateService(){

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

        $endpoint = $this->URL_SERVICE . 'Rate';


        return $this->getErrorResponse(-1,"Método no implementado " . $endpoint);
    }



    //------------------ funciones de creacion de objetos

    

    //------------------------ UTILIDADES DE LA APLICACION ------------------------------
    private function getErrorResponse($code, $message){
        $response = new MessageResponse();
        $response->responseCode = $code;
        $response->message = $message;
        return $response;
    }

    private function getMessageResponse($code, $message,$data){
        $response = new MessageResponse();
        $response->responseCode = $code;
        $response->message = $message;
        $response->data = $data;
        return $response;
    }

    private function getMessageResponseNoData($code, $message){
        $response = new MessageResponse();
        $response->responseCode = $code;
        $response->message = $message;
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

    private function parseSaveErrors($errors){

        $message = "";
        
		
        foreach ($errors as $key => $value){
			foreach($value as $v){
				$message .= $v . ", ";
			}
		}
		
		
		return $message;
    }



    /**
     * Creador de LOG de archivos
     */
    public function crearLog($dirName, $nombreArchivo,$message){
        
        $basePath = Yii::getAlias('@app'); 
        $fichero = $basePath.'/' . $dirName . '/'.$nombreArchivo.'.log';

        $logData =  Utils::getFechaActual()."\n".$message."\n\n";
        
        $fp = fopen($fichero,"a");
        fwrite($fp,$logData);
        fclose($fp);
    }



    /**
     * Agrega la informacion a los analiticos de la aplicacion
     */
    private function createAnalyticsEvent($uddUser, $app, $accion,$tipoEvento){
        $url = "https://www.google-analytics.com/collect?v=1&tid=UA-117925414-1&ev=2&an=galstore-api&t=event" .
        "&av=" . self::APPI_VERSION . 
        "&cid=" . $uddUser .
        "&aid=" . $app . 
        "&ec=". $accion . 
        "&ea=" . $tipoEvento;

        $ch = curl_init(); 

        // set url 
        curl_setopt($ch, CURLOPT_URL, $url); 

        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

        // $output contains the output string 
        curl_exec($ch); 

        // close curl resource to free up system resources 
        curl_close($ch);      
    }
}