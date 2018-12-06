<?php


namespace app\_360Utils\Services;

use Yii;

use app\_360Utils\Entity\Cotizacion;
use app\_360Utils\Entity\CompraEnvio;
use app\_360Utils\Entity\ResultadoEnvio;

class EstafetaServices{

    const ID_USUARIO = 1;
    const USUARIO = 'AdminUser';
    const PASSWORD = ',1,B(vVi';

    const SOBRE_ALTO    = 30;
    const SOBRE_ANCHO   = 17;
    const SOBRE_LARGO   = 1;

           
    function cotizarEnvioDocumento($origenCP,$destinoCP,$fecha, $paquetes, $montoSeguro = false){

        //TODO manejar varios paquetes
        $largo  = '' . self::SOBRE_LARGO;
        $ancho  = '' . self::SOBRE_ANCHO;
        $alto   = '' . self::SOBRE_ALTO;
        $peso   = '' . $paquetes[0]['num_peso'];

        
        $path_to_wsdl = Yii::getAlias('@app') . '/_360Utils/shipment-carriers/estafeta/wsdl/Frecuenciacotizador.wsdl';
        ini_set("soap.wsdl_cache_enabled", "0");

        $client = new \SoapClient($path_to_wsdl, array('trace' => 1));

        $request = [];
        $request['idusuario'] = $this::ID_USUARIO;
        $request['usuario'] = $this::USUARIO;
        $request['contra'] = $this::PASSWORD;
        $request['esFrecuencia'] = false;
        $request['esLista'] = true;
        $request['esPaquete'] = false;
        
        $request['tipoEnvio']['EsPaquete'] = false;
        $request['tipoEnvio']['Largo'] = $largo;
        $request['tipoEnvio']['Peso'] = $peso;
        $request['tipoEnvio']['Alto'] = $alto;
        $request['tipoEnvio']['Ancho'] = $ancho;

        $request['datosOrigen'] = [];
        $request['datosOrigen']['string'] = $origenCP;
        
        $request['datosDestino'] = [];
        $request['datosDestino']['string'] = $destinoCP;
        


        $response = $client->FrecuenciaCotizador($request);


        if(!isset($response->FrecuenciaCotizadorResult) || !isset($response->FrecuenciaCotizadorResult->Respuesta)){
            return null;
        }

        $respuesta = $response->FrecuenciaCotizadorResult->Respuesta;
        if($respuesta->Error != "000"){
            error_log("Se presento un error con Estafeta " . $respuesta->Error . " " . $respuesta->MensajeError);
            return null;
        }

        $tipoServicioList = $response->FrecuenciaCotizadorResult->Respuesta->TipoServicio->TipoServicio;

        $res = [];
        foreach($tipoServicioList as $item){
    
            $cotizacion = new Cotizacion();
            $cotizacion->provider = "Estafeta";
            $cotizacion->price = $item->CostoTotal;
            $cotizacion->tax = 0;
            $cotizacion->serviceType = $item->DescripcionServicio;
            $cotizacion->deliveryDate = "";
            $cotizacion->currency = "";
            $cotizacion->data = $response;
            $cotizacion->servicePacking = "";
            
            //$cotizacion->deliveryDateStr = "";
            $cotizacion->serviceTypeStr = $item->DescripcionServicio;

            array_push($res,$cotizacion);
            
        }
        return $res;
    }





    function cotizarEnvioPaquete($origenCP,$destinoCP,$fecha, $paquetes, $montoSeguro = false){

    
        //TODO manejar varios paquetes
        $largo = $paquetes[0]['num_largo'];
        $ancho = $paquetes[0]['num_largo'];
        $alto = $paquetes[0]['num_largo'];
        $peso = $paquetes[0]['num_peso'];

        
        $path_to_wsdl = Yii::getAlias('@app') . '/_360Utils/shipment-carriers/estafeta/wsdl/Frecuenciacotizador.wsdl';
        ini_set("soap.wsdl_cache_enabled", "0");

        $client = new \SoapClient($path_to_wsdl, array('trace' => 1));

        $request = [];
        $request['idusuario'] = $this::ID_USUARIO;
        $request['usuario'] = $this::USUARIO;
        $request['contra'] = $this::PASSWORD;
        $request['esFrecuencia'] = false;
        $request['esLista'] = true;
        $request['esPaquete'] = false;
        
        $request['tipoEnvio']['EsPaquete'] = true;
        $request['tipoEnvio']['Largo'] = $largo;
        $request['tipoEnvio']['Peso'] = $peso;
        $request['tipoEnvio']['Alto'] = $alto;
        $request['tipoEnvio']['Ancho'] = $ancho;

        $request['datosOrigen'] = [];
        $request['datosOrigen']['string'] = $origenCP;
        
        $request['datosDestino'] = [];
        $request['datosDestino']['string'] = $destinoCP;
        


        $response = $client->FrecuenciaCotizador($request);


        if(!isset($response->FrecuenciaCotizadorResult) || !isset($response->FrecuenciaCotizadorResult->Respuesta)){
            return null;
        }

        $respuesta = $response->FrecuenciaCotizadorResult->Respuesta;
        if($respuesta->Error != "000"){
            error_log("Se presento un error con Estafeta " . $respuesta->Error . " " . $respuesta->MensajeError);
            return null;
        }

        $tipoServicioList = $response->FrecuenciaCotizadorResult->Respuesta->TipoServicio->TipoServicio;

        $res = [];
        foreach($tipoServicioList as $item){

            //Si la opcion es LTL (pallets) no aplica
            if($item->DescripcionServicio == "LTL"){
                continue;
            }
    
            $cotizacion = new Cotizacion();
            $cotizacion->provider = "Estafeta";
            $cotizacion->price = $item->CostoTotal;
            $cotizacion->tax = 0;
            $cotizacion->serviceType = $item->DescripcionServicio;
            $cotizacion->deliveryDate = "";
            $cotizacion->currency = "";
            $cotizacion->data = $response;
            $cotizacion->servicePacking = "";
            
            //$cotizacion->deliveryDateStr = "";
            $cotizacion->serviceTypeStr = $item->DescripcionServicio;

            array_push($res,$cotizacion);
            
        }
        return $res;
    }
}

?>