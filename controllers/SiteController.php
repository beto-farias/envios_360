<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\CatProductos;
use app\dgomUtils\Pagos;
use app\dgomUtils\OpenPayServices;
use app\models\EntPagosRecibidos;
use app\models\EntUsuarios;
use app\models\EntRecuperarPass;
use app\dgomUtils\Email;
use app\models\dgomShop\Productos;
use app\models\EntClientes;
use app\models\dgomShop\ClientesUtils;
use app\models\dgomShop\Utils;
use yii\web\NotFoundHttpException;
use app\models\EntDirecciones;
use app\models\ResponseServices;
use yii\db\Expression;
use app\models\EntProductos;
use app\models\EntOpenpayPayments;
use app\models\WrkVentas;
use app\models\EntProductosImagenes;
use app\models\WrkStock;
use app\models\WrkDatosCompras;
use app\_360Utils\Services\FedexServices;


class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'pago-tarjeta', 'pago-establecimiento'],
                'rules' => [
                    [
                        'actions' => ['logout', 'pago-tarjeta', 'pago-establecimiento'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            // 'verbs' => [
            //     'class' => VerbFilter::className(),
            //     'actions' => [
            //         'logout' => ['post'],
            //     ],
            // ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex(){

        if(isset($_POST['cp_origen'])  &&isset($_POST['cp_destino'])  ){
            return $this->render('index',[
                'cp_origen'=> $_POST['cp_origen'],
                'cp_destino'=>$_POST['cp_destino']
            ]);    
        }

        return $this->render('indexDocumento');
    }

    public function actionIndexPaquete(){
        return $this->render('indexPaquete');
    }


    public function actionPurchaseDocumento($carrier = null, $service_type = null, $cpOrigen=null,$paisOrigen=null,$cpDestino=null,$paisDestino=null, $peso = null){
        $model  = new WrkDatosCompras();

        $model->txt_servicio = $carrier;
        $model->txt_tipo_servicio = $service_type;
        $model->uuid = uniqid('purchase_');
        $model->txt_tipo_empaque = "FEDEX_ENVELOPE";
        $model->txt_data = ".";

        $model->txt_origen_cp = $cpOrigen;
        $model->txt_origen_pais = $paisOrigen;

        $model->txt_destino_cp = $cpDestino;
        $model->txt_destino_pais = $paisDestino;

        $model->txt_peso = $peso;
        
        if($model->load(Yii::$app->request->post())){
            $model->uuid = uniqid('purchase_');
            Yii::info("Envio recibido");
            $model = $this->comprarFedexDocumento($model);
            
            if($model->save()){
                return $this->render('purchaseSuccess',['model'=>$model]);
            }
        }
        
        return $this->render('purchase',['model'=>$model]);
    }

    public function actionPurchasePaquete($carrier = null, $service_type = null, $cpOrigen=null,$paisOrigen=null,$cpDestino=null,$paisDestino=null, $peso = null, $alto,$ancho,$largo){
        $model  = new WrkDatosCompras();

        $model->txt_servicio = $carrier;
        $model->txt_tipo_servicio = $service_type;
        $model->uuid = uniqid('purchase_');
        $model->txt_tipo_empaque = "YOUR_PACKAGING";
        $model->txt_data = ".";

        $model->txt_origen_cp = $cpOrigen;
        $model->txt_origen_pais = $paisOrigen;

        $model->txt_destino_cp = $cpDestino;
        $model->txt_destino_pais = $paisDestino;

        $model->txt_peso = $peso;
        $model->txt_alto = $alto;
        $model->txt_ancho = $ancho;
        $model->txt_largo = $largo;
        
        if($model->load(Yii::$app->request->post())){
            $model->uuid = uniqid('purchase_');
            Yii::info("Envio recibido");
            $model = $this->comprarFedexPaquete($model);
            
            if($model->save()){
                return $this->render('purchaseSuccess',['model'=>$model]);
            }
        }
        
        return $this->render('purchase',['model'=>$model]);
    }


    public function actionDownloadLabel($uuid = null){
        $layout = false;
        if($uuid == null){
            return;
        }

        $model = WrkDatosCompras::find()->where(['uuid'=>$uuid])->one();

        if($model == null){
            return;
        }

        $data = base64_decode($model->txt_envio_label);
        header('Content-Type: application/pdf');
        echo $data;
        return "";
    }


    //-----------------------------

    private function comprarFedexDocumento(WrkDatosCompras $model){
        $fedex = new FedexServices();
        $response = $fedex->comprarEnvioDocumento($model);

        $model->txt_data = json_encode($response);
        $data = [];
        $data['notifications'] = $response->Notifications;
        $data['job_id']= $response->JobId;
        $data['master_tracking_id'] = $response->CompletedShipmentDetail->MasterTrackingId;
        $data['label_pdf'] = base64_encode($response->CompletedShipmentDetail->CompletedPackageDetails->Label->Parts->Image);

        $model->txt_envio_code = $data['master_tracking_id']->TrackingNumber;
        $model->txt_envio_code_2 = $data['master_tracking_id']->FormId;
        $model->txt_envio_label = $data['label_pdf'];

        return $model;
    }



    private function comprarFedexPaquete(WrkDatosCompras $model){
        $fedex = new FedexServices();
        $response = $fedex->comprarEnvioPaquete($model);

        $model->txt_data = json_encode($response);
        $data = [];
        $data['notifications'] = $response->Notifications;
        $data['job_id']= $response->JobId;
        $data['master_tracking_id'] = $response->CompletedShipmentDetail->MasterTrackingId;
        $data['label_pdf'] = base64_encode($response->CompletedShipmentDetail->CompletedPackageDetails->Label->Parts->Image);

        $model->txt_envio_code = $data['master_tracking_id']->TrackingNumber;
        $model->txt_envio_code_2 = $data['master_tracking_id']->FormId;
        $model->txt_envio_label = $data['label_pdf'];

        return $model;
    }


    
    
}
