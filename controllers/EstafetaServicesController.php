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

        $path_to_wsdl = Yii::getAlias('@app') . '/vendor/shipment-carriers/estafeta/wsdl/EstafetaLabelWS.wsdl';
        ini_set("soap.wsdl_cache_enabled", "0");

        $client = new \SoapClient($path_to_wsdl, array('trace' => 1));

        $request = [];
        /*
        $request['idusuario'] = $this::ID_USUARIO;
        $request['usuario'] = $this::USUARIO;
        $request['contra'] = $this::PASSWORD;
        $request['esFrecuencia'] = false;
        $request['esLista'] = true;
        */
        $request['customerNumber'] = '3001710';


        $request['labelDescriptionListCount'] = 1;
        $request['login'] = 'crosstec';
        $request['paperType'] = 1;
        $request['password'] = 'Cr0s5t3c';
        $request['quadrant'] = 0; 
        $request['suscriberId'] = 'AI';
        $request['valid'] = true;

        
        

        $request['labelDescriptionList'] = [];
        $request['labelDescriptionList']['numberOfLabels'] = 1;
        $request['labelDescriptionList']['officeNum'] =130;
        $request['labelDescriptionList']['originZipCodeForRouting'] =  $json->shiper->postal_code;
        $request['labelDescriptionList']['parcelTypeId'] =  1; //TODO validar el tipo de parcela
        $request['labelDescriptionList']['reference'] =  'Referencia'; //TODO validar las referencias del envio
        $request['labelDescriptionList']['returnDocument'] =  false;
        $request['labelDescriptionList']['serviceTypeId'] =  70; //TODO validar el service type
        $request['labelDescriptionList']['valid'] =  true;
        $request['labelDescriptionList']['weight'] =  $json->package->peso_kg; //TODO validar el peso
        $request['labelDescriptionList']['DRAlternativeInfo'] = $this->createAddressInfo(
                                                                    $json->recipient->address_line,
                                                                    '', 
                                                                    $json->recipient->phone_number,
                                                                    $json->recipient->city,
                                                                    $json->recipient->person_name,
                                                                    $json->recipient->company_name,
                                                                    '0000000',
                                                                    '',
                                                                    $json->recipient->phone_number,
                                                                    $json->recipient->state_code,
                                                                    $json->recipient->postal_code);

        $request['labelDescriptionList']['aditionalInfo'] =  'Operacion 5';
        $request['labelDescriptionList']['content'] =  'Contenido';
        $request['labelDescriptionList']['contentDescription'] = 'Descripcion del contenido'; 
        $request['labelDescriptionList']['costCenter'] =  '12345';
        $request['labelDescriptionList']['deliveryToEstafetaOffice'] = false; 
        $request['labelDescriptionList']['destinationCountryId'] = $json->recipient->country_code;
        

        $request['labelDescriptionList']['originInfo'] = $this->createAddressInfo(
            $json->shiper->address_line,
            '', 
            $json->shiper->phone_number,
            $json->shiper->city,
            $json->shiper->person_name,
            $json->shiper->company_name,
            '0000000',
            '',
            $json->shiper->phone_number,
            $json->shiper->state_code,
            $json->shiper->postal_code);


        $request['labelDescriptionList']['destinationInfo'] = $this->createAddressInfo(
            $json->recipient->address_line,
            '', 
            $json->recipient->phone_number,
            $json->recipient->city,
            $json->recipient->person_name,
            $json->recipient->company_name,
            '0000000',
            '',
            $json->recipient->phone_number,
            $json->recipient->state_code,
            $json->recipient->postal_code);
    


        //return $request;
           try{ 
        $response = $client->createLabel($request);
           }catch(\Exception $e){}

        echo $client->__getLastRequest();
        echo $client->__getLastResponse();

        //return $response;
        
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



    //------------------ funciones de creacion de objetos

    private function createAddressInfo($add1, $add2, $celPhone,$city,$contactName,$corporateName,$customerNumber,$neighborhood,$phoneNumber,$state,$zipCode){
        $data = [];
        
        $data['address1'] = 'addres origen destino';//$add1;
        $data['address2'] =  'addr 2';//;$add2;
        $data['cellPhone'] =  $celPhone;
        $data['city'] =  $city;
        $data['contactName'] = $contactName;
        $data['corporateName'] = $corporateName;
        $data['customerNumber'] =  $customerNumber;
        $data['neighborhood'] =  'neighborhood';$neighborhood;
        $data['phoneNumber'] =  $phoneNumber;
        $data['state'] =  $state;
        $data['valid'] =  true;
        $data['zipCode'] = $zipCode;
               
        return $data;
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
