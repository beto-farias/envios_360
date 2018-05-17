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



class ServicesController extends \yii\rest\Controller{

    const FEDEX_KEY = 'VY3a8M7siRPxvdOf';
    const FEDEX_PASSWORD = 'W48oom2vQa4Sqt9tn1kuP7ihk'; 
    const FEDEX_PARENT_PASSWORD = 'XXX';
	const FEDEX_PARENT_KEY= 'VY3a8M7siRPxvdOf'; 
	const FEDEX_SHIP_ACCOUNT = '510088000';
	const FEDEX_BILL_ACCOUNT = '510088000';
	const FEDEX_LOCATION_ID = 'PLBA';
	const FEDEX_METER = '119037066';


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


    public function actionValidateCp(){
        require(Yii::getAlias('@app') . '/vendor/shipment-carriers/fedex/fedex-common.php');
        $path_to_wsdl = Yii::getAlias('@app') . '/vendor/shipment-carriers/fedex/wsdl/CountryService_v6.wsdl';
        ini_set("soap.wsdl_cache_enabled", "0");
 
        $client = new \SoapClient($path_to_wsdl, array('trace' => 1));

        $request['WebAuthenticationDetail'] = array(
            'ParentCredential' => array(
                'Key' => $this::FEDEX_PARENT_KEY, 
                'Password' => $this::FEDEX_PARENT_PASSWORD
            ),
            'UserCredential' => array(
                'Key' => $this::FEDEX_KEY, 
                'Password' => $this::FEDEX_PASSWORD
            )
        );
        
        $request['ClientDetail'] = array(
            'AccountNumber' => $this::FEDEX_SHIP_ACCOUNT, 
            'MeterNumber' => $this::FEDEX_METER
        );
        $request['TransactionDetail'] = array('CustomerTransactionId' => ' *** Validate Postal Code Request using PHP ***');
        $request['Version'] = array(
            'ServiceId' => 'cnty', 
            'Major' => '6', 
            'Intermediate' => '0', 
            'Minor' => '0'
        );
        
        $request['ShipDateTime'] = '2019-02-05T12:34:56-06:00';
        
        $request['Address'] = array(
            'PostalCode' => '53240',
            'CountryCode' => 'MX'
        );
        
        $request['CarrierCode'] = 'FDXE';
        
        try {
            if(setEndpoint('changeEndpoint')){
                $newLocation = $client->__setLocation(setEndpoint('endpoint'));
            }
            
            $response = $client -> validatePostal($request);
                
            if ($response -> HighestSeverity != 'FAILURE' && $response -> HighestSeverity != 'ERROR'){  	
                
                $data = [];
                $data['message'] =  $this->parseResponse($response);
                $data['notificatios'] = $response -> Notifications;
                $data['details'] = $response -> PostalDetail;
                
                

                $res = $this->getMessageResponse("1",'Valida CP FEDEX', $data);
                return $res;
            }else{
                
            } 
        
        } catch (SoapFault $exception) {
               
        }


        $response = $this->getMessageResponseNoData("1","response");

        return $response;
    }


    

    private function parseResponse($response){
    $highestSeverity=$response->HighestSeverity;
    $message = "";
	if($highestSeverity=="SUCCESS"){$message = 'The transaction was successful.';}
	if($highestSeverity=="WARNING"){$message = 'The transaction returned a warning.';}
	if($highestSeverity=="ERROR"){$message = 'The transaction returned an Error.';}
    if($highestSeverity=="FAILURE"){$message = 'The transaction returned a Failure.';}
    
    return $message;
    }


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
