<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\MessageResponse;
use app\_360Utils\FedexServices;
use app\_360Utils\Cotizacion;




class ServicesController extends ServicesBaseController
{

    public $enableCsrfValidation = false;
    public $layout = null;


    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => null,
                'Access-Control-Max-Age' => 86400,
            ],
        ];
        return $behaviors;
    }

    public function init()
    {
        parent::init();        
        date_default_timezone_set('America/Mexico_City');
      }

    
    public function beforeAction($action){
        // your custom code here, if you want the code to run before action filters,
        // which are triggered on the [[EVENT_BEFORE_ACTION]] event, e.g. PageCache or AccessControl

        if (!parent::beforeAction($action)) {
            return false;
        }

        $headers = Yii::$app->request->headers;

        $key = $headers->get('api-key');
        $secret = $headers->get('api-secret');

        if($key != $this::API_KEY || $secret != $this::API_SECRET){
            echo(\json_encode( $this->getErrorResponse($this::ERROR_API,'Invalid API or Secret') ));
            return false;
        }


        //Pone el header de cerrar la conexión
        //$headers = Yii::$app->response->headers;
        //$headers->set('Connection', 'close');

        //Si la accion solicitada se encientra en el arreglo, no pide el token de autenticacion
        $enabledActions = array("login","version-android","version-ios");
        if(in_array($action->id,$enabledActions)){
            return true;
        }

        
        
        //Valida el token de autenticacion
        
            
        // returns the Accept header value
        $auth = $headers->get('Authentication-Token');

        /*
        $wrkSesion = TmpSesionesOficilaes::find()->where(['txt_token'=>$auth])->one();
        

        //1 Si no existe la sesion lo manda a volar
        if(is_null($wrkSesion)){
            echo(\json_encode( $this->getErrorResponse($this::ERROR_SESION_USUARIO_INVALIDA,'Sesion del usuario invalida') ));
            return false;
        }
        
        
        
        //2 verifica el tiempo de la sesion, si han pasado más de X minutos
        if(\strtotime('now') - \strtotime($wrkSesion->fch_last_update) > $this::SESION_DURACION_MINUTOS ){
            echo(\json_encode( $this->getErrorResponse($this::ERROR_SESION_DURACION_MINUTOS,'Sesion del usuario caducada') ));
            return false;
        }

        $wrkSesion->fch_last_update = date('Y-m-d H:i:s', time());
        $wrkSesion->save();

        */
        return true; // or false to not run the action
    }



  

    //-------------------------------- funciones de negocio ---------------------------------------

    
    public function actionRequestCotizacionDocumento(){
        $requiredParams = [
            'cp_origen'=>'CP Origen', 
            'pais_origen'=>'2 Letras del pais origen',
            'cp_destino'=>'CP destino',
            'pais_destino'=>'2 Letras del pais destino',
            'peso_kilogramos'=>'Peso en kg'
        ];


        $valid = $this->validateData($GLOBALS["HTTP_RAW_POST_DATA"],$requiredParams);

        if($valid != null){
            return $valid;
        }


        //-------- INICIA EL PROCESO DE NEGOCIO ---------------------------
    
        $json = json_decode($GLOBALS["HTTP_RAW_POST_DATA"]);



        // Servicios habilitados para la cotización
        //TODO: verifica si FEDEX extá disponible
        $useFedex = true;
        //TODO: verifica si DGOM extá disponible
        $useDgom = true;

        //Resultado de la busqueda
        $data = [];

       
       // UTILIZA FEDEX ---------------------------------
        if($useFedex){
            $res = $this->cotizaDocumentoFedex($json);
            $data = array_merge($data, $res);
            
        }

        // UTILIZA 2GOM ---------------------------------
        if($useDgom){
            $res = $this->cotizaDocumentoDGOM($json);
            $data = array_merge($data, $res);
        }

        return $data;

    }


    public function actionRequestCotizacionPaquete(){
        $requiredParams = [
            'cp_origen'=>'CP Origen', 
            'pais_origen'=>'2 Letras del pais origen',
            'cp_destino'=>'CP destino',
            'pais_destino'=>'2 Letras del pais destino',
            'peso_kilogramos'=>'Peso en kg',
            'alto_cm'=>'Alto en cm',
            'ancho_cm'=>'Ancho en cm',
            'largo_cm'=>'Largo en cm'
        ];


        $valid = $this->validateData($GLOBALS["HTTP_RAW_POST_DATA"],$requiredParams);

        if($valid != null){
            return $valid;
        }


        //-------- INICIA EL PROCESO DE NEGOCIO ---------------------------
    
        $json = json_decode($GLOBALS["HTTP_RAW_POST_DATA"]);



        // Servicios habilitados para la cotización
        //TODO: verifica si FEDEX extá disponible
        $useFedex = true;
        //TODO: verifica si DGOM extá disponible
        $useDgom = true;

        //Resultado de la busqueda
        $data = [];

       
       // UTILIZA FEDEX ---------------------------------
        if($useFedex){
            $res = $this->cotizaPaqueteFedex($json);
            $data = array_merge($data, $res);
            
        }

        // UTILIZA 2GOM ---------------------------------
        if($useDgom){
            $res = $this->cotizaDocumentoDGOM($json);
            $data = array_merge($data, $res);
        }

        return $data;

    }



    //---------------------------------- COTIZACION DE DGOM -----------------------------------

    private function cotizaDocumentoDGOM($json){
        $data = [];

        $cotizacion = new Cotizacion();

        $cotizacion->provider     = "DGOM";
        $cotizacion->price        = 100;
        $cotizacion->tax          = 16;
        $cotizacion->serviceType  = "FIRST_OVERNIGHT";//, PRIORITY_OVERNIGHT
        $cotizacion->deliveryDate = "2018-11-10";
        $cotizacion->currency     = "MXP";
        
        array_push($data, $cotizacion);

        $cotizacion = new Cotizacion();

        $cotizacion->provider     = "DGOM-2";
        $cotizacion->price        = 150;
        $cotizacion->tax          = 16;
        $cotizacion->serviceType  = "PRIORITY_OVERNIGHT";//, 
        $cotizacion->deliveryDate = "2018-11-10";
        $cotizacion->currency     = "MXP";
        
        array_push($data, $cotizacion);

        return $data;
    }


    

//---------------------------------- COTIZACION DE FEDEX -----------------------------------

    private function cotizaDocumentoFedex($json){
        // Metodos de envio disponibles

        $fedex = new FedexServices();
        //FIXME: fecha actual
        $fecha = "2018-10-06";
        $disponiblidad = $fedex->disponibilidadDocumento($json->cp_origen, $json->pais_origen, $json->cp_destino, $json->pais_destino, $fecha);

        if(!$disponiblidad){
            return [];
        }
        
        
        //Por cada opcion de disponibilidad verifica el precio
        $data = [];
        $data['notifications']  = $disponiblidad->Notifications;
        $data['options']        = $disponiblidad->Options;

        // FIXME 
        $fecha = date('c');

        $cotizaciones = [];
        $count = 0;
        foreach($data['options'] as $item){
            $service = $item->Service;

            $cotizacion = $fedex->cotizarEnvioDocumento($service, $json->cp_origen, $json->pais_origen, $json->cp_destino, $json->pais_destino, $fecha, $json->peso_kilogramos);
            if($cotizacion){
                array_push($cotizaciones, $cotizacion);
            }

            $count++;
            if($count >1){
                break;
            }
        }



        return $cotizaciones;

    }


    private function cotizaPaqueteFedex($json){
        // Metodos de envio disponibles

        $fedex = new FedexServices();
        //FIXME: fecha actual
        $fecha = "2018-10-06";
        $disponiblidad = $fedex->disponibilidadPaquete($json->cp_origen, $json->pais_origen, $json->cp_destino, $json->pais_destino, $fecha);

        if(!$disponiblidad){
            return [];
        }
        
        
        //Por cada opcion de disponibilidad verifica el precio
        $data = [];
        $data['notifications']  = $disponiblidad->Notifications;
        $data['options']        = $disponiblidad->Options;

        // FIXME 
        $fecha = date('c');

        $cotizaciones = [];
        $count = 0;
        foreach($data['options'] as $item){
            $service = $item->Service;

            $cotizacion = $fedex->cotizarEnvioPaquete($service, $json->cp_origen, $json->pais_origen, $json->cp_destino, $json->pais_destino, $fecha, $json->peso_kilogramos, $json->alto_cm,$json->ancho_cm,$json->largo_cm);
            if($cotizacion){
                array_push($cotizaciones, $cotizacion);
            }

            $count++;
            if($count >1){
                break;
            }
        }



        return $cotizaciones;

    }
    
}


?>