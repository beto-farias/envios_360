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



class FedexServicesController extends \yii\rest\Controller{

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


        require(Yii::getAlias('@app') . '/_360Utils/shipment-carriers/fedex/fedex-common.php');
        $path_to_wsdl = Yii::getAlias('@app') . '/_360Utils/shipment-carriers/fedex/wsdl/ShipService_v21.wsdl';
        ini_set("soap.wsdl_cache_enabled", "0");

        $client = new \SoapClient($path_to_wsdl, array('trace' => 1));
        $request = $this->configClientRequest();

        $request['TransactionDetail'] = array('CustomerTransactionId' => '*** Express International Shipping Request using PHP ***');
        $request['Version'] = array(
            'ServiceId' => 'ship', 
            'Major' => '21', 
            'Intermediate' => '0', 
            'Minor' => '0'
        );
        $request['RequestedShipment'] = array(
            'ShipTimestamp' => date('c'),
            'DropoffType' => 'REGULAR_PICKUP', // valid values REGULAR_PICKUP, REQUEST_COURIER, DROP_BOX, BUSINESS_SERVICE_CENTER and STATION
            'ServiceType' => $json->service_type, // valid values STANDARD_OVERNIGHT, PRIORITY_OVERNIGHT, FEDEX_GROUND, ...
            'PackagingType' => $json->service_packing, // valid values FEDEX_BOX, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING, ...
            
            
            'Recipient' => $this->addRecipient(
                $json->recipient->postal_code,
                $json->recipient->country_code, 
                $json->recipient->city,
                $json->recipient->state_code,
                $json->recipient->person_name,
                $json->recipient->phone_number,
                $json->recipient->address_line,
                $json->recipient->company_name
            ),
            'Shipper' => $this->addRecipient(
                $json->shiper->postal_code,
                $json->shiper->country_code, 
                $json->shiper->city,
                $json->shiper->state_code,
                $json->shiper->person_name,
                $json->shiper->phone_number,
                $json->shiper->address_line,
                $json->shiper->company_name
            ),
       

            'ShippingChargesPayment' => $this->addShippingChargesPayment(),
            //'CustomsClearanceDetail' => addCustomClearanceDetail(),                                                                                                       
            'LabelSpecification' => $this->addLabelSpecification(),
            'CustomerSpecifiedDetail' => array(
                'MaskedData'=> 'SHIPPER_ACCOUNT_NUMBER'
            ), 
            'PackageCount' => 1,
                'RequestedPackageLineItems' => array(

                '0' => $this->addPackageLineItem($json->package->peso_kg, $json->package->largo_cm,$json->package->ancho_cm,$json->package->alto_cm)
            ),
            'CustomerReferences' => array(
                '0' => array(
                    'CustomerReferenceType' => 'CUSTOMER_REFERENCE', 
                    'Value' => 'TC007_07_PT1_ST01_PK01_SNDUS_RCPCA_POS'
                )
            )
        );



        try{
            if(setEndpoint('changeEndpoint')){
                $newLocation = $client->__setLocation(setEndpoint('endpoint'));
            }
            
            $response = $client->processShipment($request); // FedEx web service invocation
        
            if ($response->HighestSeverity != 'FAILURE' && $response->HighestSeverity != 'ERROR'){
                


                $data = [];
                $data['notifications'] = $response->Notifications;
                $data['job_id']= $response->JobId;
                $data['master_tracking_id'] = $response->CompletedShipmentDetail->MasterTrackingId;
                $data['label_pdf'] = base64_encode($response->CompletedShipmentDetail->CompletedPackageDetails->Label->Parts->Image);

                //return $data;
                return $response;         
            }else{
                printError($client, $response);
            }
        
            writeToLog($client);    // Write to log file
        } catch (SoapFault $exception) {
            printFault($exception, $client);
        }
    }


    /**
     * Valida que se pueda realizar el envio, origen destino
     */
    public function actionValidateService(){

        //Validacion de entrada
        $error = new MessageResponse();
        if(!$this->validateRequiredParam($error,isset($GLOBALS["HTTP_RAW_POST_DATA"]), "Raw Data" )){
            return $error;
        }

        $json = json_decode($GLOBALS["HTTP_RAW_POST_DATA"] );

        
        if(!$this->validateRequiredParam($error,isset($json->shiper->postal_code), "Shipper CP" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->shiper->country_code), "Shipper Country code" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->recipient->postal_code), "Recipient CP" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->recipient->country_code), "Recipient Country code" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->ship_date), "Fecha de envío YYYY-MM-DD (maximo de 10 días a futuro)" )){
            return $error;
        }

        if(!isset($json->service_packing)){
            $json->service_packing = 'YOUR_PACKAGING';
        }

        

        require(Yii::getAlias('@app') . '/_360Utils/shipment-carriers/fedex/fedex-common.php');
        $path_to_wsdl = Yii::getAlias('@app') . '/_360Utils/shipment-carriers/fedex/wsdl/ValidationAvailabilityAndCommitmentService_v8.wsdl';
        ini_set("soap.wsdl_cache_enabled", "0");

        $client = new \SoapClient($path_to_wsdl, array('trace' => 1));
        $request = $this->configClientRequest();

        $request['TransactionDetail'] = array('CustomerTransactionId' => ' *** Service Availability Request v5.1 using PHP ***');
        $request['Version'] = array(
            'ServiceId' => 'vacs', 
            'Major' => '8',
            'Intermediate' => '0', 
            'Minor' => '0'
        );
        $request['Origin'] = array(
            'PostalCode' => $json->shiper->postal_code, // Origin details
            'CountryCode' => $json->shiper->country_code
        );
        $request['Destination'] = array(
            'PostalCode' => $json->recipient->postal_code, // Destination details
            'CountryCode' => $json->recipient->country_code
        );
        $request['ShipDate'] = $json->ship_date;
        $request['CarrierCode'] = 'FDXE'; // valid codes FDXE-Express, FDXG-Ground, FDXC-Cargo, FXCC-Custom Critical and FXFR-Freight
        //$request['Service'] = 'PRIORITY_OVERNIGHT'; // valid code STANDARD_OVERNIGHT, PRIORITY_OVERNIGHT, FEDEX_GROUND, ...
        $request['Packaging'] = $json->service_packing; // valid code FEDEX_BOX, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING, ...


        try {
            if(setEndpoint('changeEndpoint')){
                $newLocation = $client->__setLocation(setEndpoint('endpoint'));
            }
            
            $response = $client->serviceAvailability($request);
                
            if ($response -> HighestSeverity != 'FAILURE' && $response -> HighestSeverity != 'ERROR'){ 
                
                $data = [];
                $data['notifications']=$response->Notifications;
                $data['options'] = $response->Options;
                $res = $this->getMessageResponse("1",'Rate Service FEDEX', $data);
                return $res;
            
            }else{
                var_dump($response);
            } 
            
        } catch (SoapFault $exception) {
           printFault($exception, $client);        
        }
    }




    /**
     * Cotiza el precio del servicio
     */
    public function actionRateService(){
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

        if(!$this->validateRequiredParam($error,isset($json->shiper->country_code), "Shipper Country code" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->recipient->postal_code), "Recipient CP" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->recipient->country_code), "Recipient Country code" )){
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




        require(Yii::getAlias('@app') . '/_360Utils/shipment-carriers/fedex/fedex-common.php');
        $path_to_wsdl = Yii::getAlias('@app') . '/_360Utils/shipment-carriers/fedex/wsdl/RateService_v22.wsdl';
        ini_set("soap.wsdl_cache_enabled", "0");

        $client = new \SoapClient($path_to_wsdl, array('trace' => 1));
        $request = $this->configClientRequest();

        $request['TransactionDetail'] = array('CustomerTransactionId' => ' *** Rate Request using PHP ***');
        $request['Version'] = array(
            'ServiceId' => 'crs', 
            'Major' => '22', 
            'Intermediate' => '0', 
            'Minor' => '0'
        );

        $request['ReturnTransitAndCommit'] = true;
        $request['RequestedShipment']['DropoffType'] = 'REGULAR_PICKUP'; // valid values REGULAR_PICKUP, REQUEST_COURIER, ...
        $request['RequestedShipment']['ShipTimestamp'] = date('c');
        $request['RequestedShipment']['ServiceType'] = $json->service_type; // valid values STANDARD_OVERNIGHT, PRIORITY_OVERNIGHT, FEDEX_GROUND, ...
        $request['RequestedShipment']['PackagingType'] = $json->service_packing; // valid values FEDEX_BOX, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING, ...
        $request['RequestedShipment']['PreferredCurrency']='MXN';
        
        $request['RequestedShipment']['RateRequestTypes']='PREFERRED';        

        $request['RequestedShipment']['TotalInsuredValue']=array(
            'Ammount'=>100,
            'Currency'=>'MXN'
        );
        $request['RequestedShipment']['Shipper'] = $this->addShipper($json->shiper->postal_code,$json->shiper->country_code);
        $request['RequestedShipment']['Recipient'] = $this->addRecipient($json->recipient->postal_code,$json->recipient->country_code);
        //$request['RequestedShipment']['ShippingChargesPayment'] = $this->addShippingChargesPayment();
        $request['RequestedShipment']['PackageCount'] = '1';
        //$pesoKg, $largoCm,$anchoCm,$altoCm
        $request['RequestedShipment']['RequestedPackageLineItems'] = $this->addPackageLineItem($json->package->peso_kg, $json->package->largo_cm,$json->package->ancho_cm,$json->package->alto_cm);

        try {
            if(setEndpoint('changeEndpoint')){
                $newLocation = $client->__setLocation(setEndpoint('endpoint'));
            }
            
            $response = $client->getRates($request);
                
            if ($response -> HighestSeverity != 'FAILURE' && $response -> HighestSeverity != 'ERROR'){  	
                $rateReply = $response->RateReplyDetails;

                //var_dump($response);
                //exit;
                
                //Tipo de servicio
                $serviceType = $rateReply->ServiceType;

                //Tipo de empaquetamient
                $servicePacking = $rateReply->PackagingType;

                

                //Precio y moneda
                if($rateReply->RatedShipmentDetails && is_array($rateReply->RatedShipmentDetails)){
                    $amount = number_format($rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount,2,".",",") ;
                    $currency = $rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Currency;
                }elseif($rateReply->RatedShipmentDetails && ! is_array($rateReply->RatedShipmentDetails)){
                    $amount =  number_format($rateReply->RatedShipmentDetails->ShipmentRateDetail->TotalNetCharge->Amount,2,".",",") ;
                    $currency = $rateReply->RatedShipmentDetails->ShipmentRateDetail->TotalNetCharge->Currency;
                }

                //Fecha de entrega
                if(array_key_exists('DeliveryTimestamp',$rateReply)){
                    $deliveryDate=  $rateReply->DeliveryTimestamp ;
                }else if(array_key_exists('TransitTime',$rateReply)){
                    $deliveryDate=  $rateReply->TransitTime ;
                }else {
                    $deliveryDate='N/A';
                }

                return $response;
                exit;

                $data = [];
                $data['notifications']=$response->Notifications;
                $data['service_type'] = $serviceType;
                $data['service_packing'] = $servicePacking;
                $data['amount'] = $amount;
                $data['currency'] = $currency;
                $data['delivery_date'] = $deliveryDate;
                
                

                $res = $this->getMessageResponse("1",'Rate Service FEDEX', $data);
                return $res;
            
            }else{
                var_dump($response);
            } 
            
        } catch (SoapFault $exception) {
           printFault($exception, $client);        
        }

    }

    

    /**
     * Valida la disponibilidad de un codigo postal
     */
    public function actionValidateCp(){

        //Validacion de entrada
        $error = new MessageResponse();
        if(!$this->validateRequiredParam($error,isset($GLOBALS["HTTP_RAW_POST_DATA"]), "Raw Data" )){
            return $error;
        }

        $json = json_decode($GLOBALS["HTTP_RAW_POST_DATA"] );

        
        if(!$this->validateRequiredParam($error,isset($json->postal_code), "CP" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->country_code), "Country code" )){
            return $error;
        }

        require(Yii::getAlias('@app') . '/_360Utils/shipment-carriers/fedex/fedex-common.php');
        $path_to_wsdl = Yii::getAlias('@app') . '/_360Utils/shipment-carriers/fedex/wsdl/CountryService_v6.wsdl';
        ini_set("soap.wsdl_cache_enabled", "0");
 
        $client = new \SoapClient($path_to_wsdl, array('trace' => 1));

        $request = $this->configClientRequest();

        $request['TransactionDetail'] = array('CustomerTransactionId' => ' *** Validate Postal Code Request using PHP ***');
        $request['Version'] = array(
            'ServiceId' => 'cnty', 
            'Major' => '6', 
            'Intermediate' => '0', 
            'Minor' => '0'
        );
        
        $request['ShipDateTime'] = '2019-02-05T12:34:56-06:00';
        
        $request['Address'] = array(
            'PostalCode' => $json->postal_code,
            'CountryCode' => $json->country_code
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



    //----------------- FUNCIONES DEL SERVICIO

    private function addShipper($cp, $countryCode , $city=null, $stateProvinceCode=null){

        $shipper = array(
            'Contact' => array(
                'PersonName' => 'Sender Name',
                'CompanyName' => 'Sender Company Name',
                'PhoneNumber' => '9012638716'
            ),
            'Address' => array(
                'StreetLines' => array('Address Line 1'),
                //'City' => 'Mexico',
                'StateOrProvinceCode' => 'EM',
                'PostalCode' => $cp,
                'CountryCode' => $countryCode
            )
        );

        if($city && $stateProvinceCode){
            $shipper['Address'] = array(
                'StreetLines' => array('Address Line 1'),
                'City' => $city,
                'StateOrProvinceCode' => $stateProvinceCode,
                'PostalCode' => $cp,
                'CountryCode' => $countryCode
            );
        }

        return $shipper;
    }





    function addRecipient($cp, $countryCode,$city=null, $stateProvinceCode=null,$personName=null,$phoneNumber=null, $addressLine = null,$companyName=null){
        $recipient = array(
            'Contact' => array(
                'PersonName' => 'Recipient Name',
                'CompanyName' => 'Company Name',
                'PhoneNumber' => '9012637906'
            ),
            'Address' => array(
                'StreetLines' => array('Address Line 1'),
                'City' => 'Mexico',
                'StateOrProvinceCode' => 'DF',
                'PostalCode' => $cp,
                'CountryCode' => $countryCode,
                'Residential' => false
            )
        );

        if($personName != null){
            $recipient['Contact'] = array(
                'PersonName' => $personName,
                'CompanyName' => $companyName,
                'PhoneNumber' => $phoneNumber
            );
        }

        if($city && $stateProvinceCode){
            $recipient['Address'] = array(
                'StreetLines' => array($addressLine),
                'City' => $city,
                'StateOrProvinceCode' => $stateProvinceCode,
                'PostalCode' => $cp,
                'CountryCode' => $countryCode
            );
        }
        return $recipient;	                                    
    }

    function addShippingChargesPayment(){
        $shippingChargesPayment = array(
            'PaymentType' => 'SENDER', // valid values RECIPIENT, SENDER and THIRD_PARTY
            'Payor' => array(
                'ResponsibleParty' => array(
                    'AccountNumber' => getProperty('billaccount'),
                    'CountryCode' => 'MX'
                )
            )
        );
        return $shippingChargesPayment;
    }

    function addPackageLineItem($pesoKg, $largoCm,$anchoCm,$altoCm){
        $packageLineItem = array(
            'SequenceNumber'=>1,
            'GroupPackageCount'=>1,
            'Weight' => array(
                'Value' => $pesoKg,
                'Units' => 'KG'
            ),
            'Dimensions' => array(
                'Length' => $largoCm,
                'Width' => $anchoCm,
                'Height' => $altoCm,
                'Units' => 'CM'
            )
        );
        return $packageLineItem;
    }

    function addLabelSpecification(){
        $labelSpecification = array(
            'LabelFormatType' => 'COMMON2D', // valid values COMMON2D, LABEL_DATA_ONLY
            'ImageType' => 'PDF',  // valid values DPL, EPL2, PDF, ZPLII and PNG
            'LabelStockType' => 'PAPER_7X4.75'
        );
        return $labelSpecification;
    }

    /**
     * Congigura los datos del proveedor
     */
    private function configClientRequest(){
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

        return $request;
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
