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
    public function actionIndex()
    {
        
    }

    
}
