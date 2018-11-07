<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wrk_datos_compras".
 *
 * @property integer $id_dato_compra
 * @property string $uuid
 * @property string $txt_servicio
 * @property string $txt_tipo_servicio
 * @property string $txt_tipo_empaque
 * @property string $txt_origen_cp
 * @property string $txt_origen_pais
 * @property string $txt_origen_ciudad
 * @property string $txt_origen_estado
 * @property string $txt_origen_direccion
 * @property string $txt_origen_nombre_persona
 * @property string $txt_origen_telefono
 * @property string $txt_origen_compania
 * @property string $txt_destino_cp
 * @property string $txt_destino_pais
 * @property string $txt_destino_ciudad
 * @property string $txt_destino_estado
 * @property string $txt_destino_direccion
 * @property string $txt_destino_nombre_persona
 * @property string $txt_destino_telefono
 * @property string $txt_destino_compania
 * @property string $txt_data
 * @property string $txt_monto_pago
 * @property string $txt_monto_iva
 * @property string $txt_tipo_moneda
 * @property string $fch_creacion
 * @property string $txt_envio_code
 * @property string $txt_envio_code_2
 * @property string $txt_envio_label
 */
class WrkDatosCompras extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wrk_datos_compras';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uuid', 'txt_servicio', 'txt_tipo_servicio', 'txt_tipo_empaque', 'txt_origen_cp', 'txt_origen_pais', 'txt_origen_ciudad', 'txt_origen_estado', 'txt_origen_direccion', 'txt_origen_nombre_persona', 'txt_origen_telefono', 'txt_origen_compania', 'txt_destino_cp', 'txt_destino_pais', 'txt_destino_ciudad', 'txt_destino_estado', 'txt_destino_direccion', 'txt_destino_nombre_persona', 'txt_destino_telefono', 'txt_destino_compania', 'txt_data', 'txt_monto_pago', 'txt_monto_iva', 'txt_tipo_moneda', 'txt_envio_code', 'txt_envio_code_2', 'txt_envio_label'], 'required'],
            [['txt_data', 'txt_envio_label'], 'string'],
            [['fch_creacion'], 'safe'],
            [['uuid', 'txt_servicio', 'txt_tipo_servicio', 'txt_tipo_empaque', 'txt_origen_ciudad', 'txt_origen_estado', 'txt_origen_direccion', 'txt_origen_nombre_persona', 'txt_origen_telefono', 'txt_origen_compania', 'txt_destino_ciudad', 'txt_destino_estado', 'txt_destino_direccion', 'txt_destino_nombre_persona', 'txt_destino_telefono', 'txt_destino_compania', 'txt_monto_pago', 'txt_monto_iva', 'txt_envio_code', 'txt_envio_code_2'], 'string', 'max' => 45],
            [['txt_origen_cp', 'txt_destino_cp'], 'string', 'max' => 5],
            [['txt_origen_pais', 'txt_destino_pais'], 'string', 'max' => 2],
            [['txt_tipo_moneda'], 'string', 'max' => 3],
            [['uuid'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_dato_compra' => 'Id Dato Compra',
            'uuid' => 'Uuid',
            'txt_servicio' => 'Txt Servicio',
            'txt_tipo_servicio' => 'Txt Tipo Servicio',
            'txt_tipo_empaque' => 'Txt Tipo Empaque',
            'txt_origen_cp' => 'Txt Origen Cp',
            'txt_origen_pais' => 'Txt Origen Pais',
            'txt_origen_ciudad' => 'Txt Origen Ciudad',
            'txt_origen_estado' => 'Txt Origen Estado',
            'txt_origen_direccion' => 'Txt Origen Direccion',
            'txt_origen_nombre_persona' => 'Txt Origen Nombre Persona',
            'txt_origen_telefono' => 'Txt Origen Telefono',
            'txt_origen_compania' => 'Txt Origen Compania',
            'txt_destino_cp' => 'Txt Destino Cp',
            'txt_destino_pais' => 'Txt Destino Pais',
            'txt_destino_ciudad' => 'Txt Destino Ciudad',
            'txt_destino_estado' => 'Txt Destino Estado',
            'txt_destino_direccion' => 'Txt Destino Direccion',
            'txt_destino_nombre_persona' => 'Txt Destino Nombre Persona',
            'txt_destino_telefono' => 'Txt Destino Telefono',
            'txt_destino_compania' => 'Txt Destino Compania',
            'txt_data' => 'Txt Data',
            'txt_monto_pago' => 'Txt Monto Pago',
            'txt_monto_iva' => 'Txt Monto Iva',
            'txt_tipo_moneda' => 'Txt Tipo Moneda',
            'fch_creacion' => 'Fch Creacion',
            'txt_envio_code' => 'Txt Envio Code',
            'txt_envio_code_2' => 'Txt Envio Code 2',
            'txt_envio_label' => 'Txt Envio Label',
        ];
    }
}
