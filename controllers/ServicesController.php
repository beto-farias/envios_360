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
            'peso_gramos'=>'Peso en gramos'
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
        $disponiblidad = $fedex->disponibilidad($json->cp_origen, $json->pais_origen, $json->cp_destino, $json->pais_destino, $fecha);

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

            $cotizacion = $fedex->cotizarEnvio($service, $json->cp_origen, $json->pais_origen, $json->cp_destino, $json->pais_destino, $fecha);
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




    /**
     * Funcion que recupera las obras habilitadas
     * filtradas por:
     *  -tipo de obra
     *  -Municipio
     */
    public function actionListObras(){
        //---------- INICIA LA VALIDACION DE LOS DATOS DE ENTRADA ----------
        $requiredParams = [
            'uddi_municipio'=>'Municipio', 
            'uddi_tipo_obra'=>'Tipo de obra'
        ];

        $valid = $this->validateData($GLOBALS["HTTP_RAW_POST_DATA"],$requiredParams);

        if($valid != null){
            return $valid;
        }

        //-------- INICIA EL PROCESO DE NEGOCIO ---------------------------
    
        $json = json_decode($GLOBALS["HTTP_RAW_POST_DATA"]);

        $municipio = CatMunicipios::find()->where(['uddi'=>$json->uddi_municipio])->one();

        if($municipio == null){
            return $this->getErrorResponse(self::ERROR_ITEM_NOT_FOUND,"Municipio no encontrado");
        }

        $tipoObra = CatTiposObras::find()->where(['uddi'=>$json->uddi_tipo_obra])->one();
        
        if($tipoObra == null){
            return $this->getErrorResponse(self::ERROR_ITEM_NOT_FOUND,"Tipo de obra no encontrado");
        }

        $order = 'txt_nombre ASC';
        if(isset($json->order_by)){
            switch($json->order_by){
            case 'name':
                $order = 'txt_nombre ASC';
                break;
            }
        }

        //Paginación
        $limit = $this->parsePageSizeJson($json); 
        $page = $this->parsePageNumberJson($json);
        $startLimit = ($page - 1) * $limit;

        $results = EntObras::find()
        ->where([
            'b_habilitado'=>1, 
            'id_municipio'=>$municipio->id_municipio,
            'id_tipo_obra'=>$tipoObra->id_tipo_obra
            ])
        
        ->limit($limit)
        ->offset($startLimit)
        ->all();

        $count = EntObras::find()
        ->where([
            'b_habilitado'=>1, 
            'id_municipio'=>$municipio->id_municipio,
            'id_tipo_obra'=>$tipoObra->id_tipo_obra
            ])
        ->limit($limit)
        ->offset($startLimit)
        ->count();

        $maxPage = ceil($count / $limit);


        foreach($results as $item){
            $item->id_tipo_obra = $item->tipoObra;
            $item->id_municipio = $item->municipio;
            $item->id_ciudad = $item->ciudad;
            $item->id_estado = $item->estado;
            $item->id_estado_obra = $item->estadoObra;
            $item->id_contratista = $item->contratista;
        }


        return $this->getListResponse($this::RESPONSE_SUCCESS, "List Obras","Listado de obras", $results, $page  ,$maxPage ,$limit );

    }

    

    
}


?>