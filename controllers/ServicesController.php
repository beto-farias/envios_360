<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\MessageResponse;

use app\_360Utils\UpsServices;
use app\_360Utils\CotizadorSobre;
use app\_360Utils\CotizadorPaquete;
use app\_360Utils\Services\GeoNamesServices;
use app\_360Utils\Services\FedexServices;

use app\_360Utils\Entity\Cotizacion;
use app\_360Utils\Entity\CompraEnvio;
use app\_360Utils\Entity\Paquete;




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



  

    //-------------------------------- funciones de negocio COTIZACION ---------------------------------------

    public function actionRequestInfoCp(){
        
        //TODO seguridad
        $requiredParams = [
            'cp'=>'CP',
            'pais'=>'Pais'
        ];

        $valid = $this->validateData($GLOBALS["HTTP_RAW_POST_DATA"],$requiredParams);

        if($valid != null){
            return $valid;
        }

         //-------- INICIA EL PROCESO DE NEGOCIO ---------------------------
         $json = json_decode($GLOBALS["HTTP_RAW_POST_DATA"]);
    
         $geoNames = new GeoNamesServices();

         $res = $geoNames->getCPData($json->cp, $json->pais);

         return $res;

    }

    
    public function actionRequestCotizacionDocumento(){
        $requiredParams = [
            'cp_origen'=>'CP Origen', 
            'pais_origen'=>'2 Letras del pais origen',
            'estado_origen'=>'2 letras del estado origen',
            'cp_destino'=>'CP destino',
            'pais_destino'=>'2 Letras del pais destino',
            'estado_destino'=>'2 letras del estado destino',
            'peso_kilogramos'=>'Peso en kg'
        ];


        $valid = $this->validateData($GLOBALS["HTTP_RAW_POST_DATA"],$requiredParams);

        if($valid != null){
            return $valid;
        }


        //-------- INICIA EL PROCESO DE NEGOCIO ---------------------------
    
        $json = json_decode($GLOBALS["HTTP_RAW_POST_DATA"]);

        $cotizador = new CotizadorSobre();

        $paquete = [];
        $paquete[0] = [
            'num_peso'=>$json->peso_kilogramos,
            'num_alto'=>0,
            'num_ancho'=>0,
            'num_largo'=>0
        ];

        return $cotizador->realizaCotizacion($json,$paquete);

    }


    /**
     * Cotiza un paquete 
     */
    public function actionRequestCotizacionPaquete(){
        $requiredParams = [
            'cp_origen'=>'CP Origen', 
            'pais_origen'=>'2 Letras del pais origen',
            'estado_origen'=>'2 letras del estado origen',
            'cp_destino'=>'CP destino',
            'pais_destino'=>'2 Letras del pais destino',
            'estado_destino'=>'2 letras del estado destino',
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

        $cotizador = new CotizadorPaquete();

        $paquete = [];
        $paquete[0] = [
            'num_peso'=>$json->peso_kilogramos,
            'num_alto'=>$json->alto_cm,
            'num_ancho'=>$json->ancho_cm,
            'num_largo'=>$json->largo_cm
        ];

        return $cotizador->realizaCotizacion($json,$paquete);

    }

    // ---------------- FUNCIONES DE NEGOCIO COMPRA --------------------------------------
    public function actionRequestCompraEnvioDocumento(){

        //TODO seguridad
        $requiredParams = [
            'carrier'=>'Tipo de servicio - Carrier',
            'tipo_servicio'=>'Tipo de envío',
            'tipo_empaque'=>'Tipo de empaque',
            'origen_cp'=>'Origen cp',
            'origen_pais'=>'Origen pais',
            'origen_ciudad'=>'Origen ciudad',
            'origen_estado'=>'Origen estado',
            'origen_direccion'=>'Origen direccion',
            'origen_nombre_persona'=>'Origen nombre persona',
            'origen_telefono'=>'Origen telefono',
            'origen_compania'=>'Origen compañia',
            'destino_cp'=>'Destino cp',
            'destino_pais'=>'Destino pais',
            'destino_ciudad'=>'Destino ciudad',
            'destino_estado'=>'Destino estado',
            'destino_direccion'=>'Destino direccion',
            'destino_nombre_persona'=>'Destino nombre persona',
            'destino_telefono'=>'Destino teléfono',
            'destino_compania'=>'Destino compañia',
            'peso_kilogramos'=>'Peso del sobre'
        ];

        $valid = $this->validateData($GLOBALS["HTTP_RAW_POST_DATA"],$requiredParams);

        if($valid != null){
            return $valid;
        }

         //-------- INICIA EL PROCESO DE NEGOCIO ---------------------------
         $json = json_decode($GLOBALS["HTTP_RAW_POST_DATA"]);


        $compra = new CompraEnvio();
        $compra->servicio = $json->carrier;
        $compra->tipo_servicio = $json->tipo_servicio;
        $compra->tipo_empaque = $json->tipo_empaque;
        $compra->origen_cp = $json->origen_cp;
        $compra->origen_pais = $json->origen_pais;
        $compra->origen_ciudad = $json->origen_ciudad;
        $compra->origen_estado = $json->origen_estado;
        $compra->origen_direccion = $json->origen_direccion;
        $compra->origen_nombre_persona = $json->origen_nombre_persona;
        $compra->origen_telefono = $json->origen_telefono;
        $compra->origen_compania = $json->origen_compania;
        $compra->destino_cp = $json->destino_cp;
        $compra->destino_pais = $json->destino_pais;
        $compra->destino_ciudad = $json->destino_ciudad;
        $compra->destino_estado = $json->destino_estado;
        $compra->destino_direccion = $json->destino_direccion;
        $compra->destino_nombre_persona = $json->destino_nombre_persona;
        $compra->destino_telefono = $json->destino_telefono;
        $compra->destino_compania = $json->destino_compania;
        
        $paquete = new Paquete();
        $paquete->peso = $json->peso_kilogramos; 
        
        $compra->addPaquete($paquete);
        

         if($json->carrier == "FEDEX"){
             $fedex = new FedexServices();
             $res = $fedex->comprarEnvioDocumento($compra);
             return $res;
         }
    }



    public function actionRequestCompraEnvioPaquete(){

        //TODO seguridad
        $requiredParams = [
            'carrier'=>'Tipo de servicio - Carrier',
            'tipo_servicio'=>'Tipo de envío',
            'tipo_empaque'=>'Tipo de empaque',
            'origen_cp'=>'Origen cp',
            'origen_pais'=>'Origen pais',
            'origen_ciudad'=>'Origen ciudad',
            'origen_estado'=>'Origen estado',
            'origen_direccion'=>'Origen direccion',
            'origen_nombre_persona'=>'Origen nombre persona',
            'origen_telefono'=>'Origen telefono',
            'origen_compania'=>'Origen compañia',
            'destino_cp'=>'Destino cp',
            'destino_pais'=>'Destino pais',
            'destino_ciudad'=>'Destino ciudad',
            'destino_estado'=>'Destino estado',
            'destino_direccion'=>'Destino direccion',
            'destino_nombre_persona'=>'Destino nombre persona',
            'destino_telefono'=>'Destino teléfono',
            'destino_compania'=>'Destino compañia',
            'peso_kilogramos'=>'Peso del sobre',
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


        $compra = new CompraEnvio();
        $compra->servicio = $json->carrier;
        $compra->tipo_servicio = $json->tipo_servicio;
        $compra->tipo_empaque = $json->tipo_empaque;
        $compra->origen_cp = $json->origen_cp;
        $compra->origen_pais = $json->origen_pais;
        $compra->origen_ciudad = $json->origen_ciudad;
        $compra->origen_estado = $json->origen_estado;
        $compra->origen_direccion = $json->origen_direccion;
        $compra->origen_nombre_persona = $json->origen_nombre_persona;
        $compra->origen_telefono = $json->origen_telefono;
        $compra->origen_compania = $json->origen_compania;
        $compra->destino_cp = $json->destino_cp;
        $compra->destino_pais = $json->destino_pais;
        $compra->destino_ciudad = $json->destino_ciudad;
        $compra->destino_estado = $json->destino_estado;
        $compra->destino_direccion = $json->destino_direccion;
        $compra->destino_nombre_persona = $json->destino_nombre_persona;
        $compra->destino_telefono = $json->destino_telefono;
        $compra->destino_compania = $json->destino_compania;
        
        $paquete = new Paquete();
        $paquete->peso = $json->peso_kilogramos; 
        $paquete->alto = $json->alto_cm;
        $paquete->ancho = $json->ancho_cm;
        $paquete->largo = $json->largo_cm;
        
        $compra->addPaquete($paquete);
        

         if($json->carrier == "FEDEX"){
             $fedex = new FedexServices();
             $res = $fedex->comprarEnvioPaquete($compra);
             return $res;
         }
    }

}


?>