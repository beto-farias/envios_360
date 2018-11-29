<?php

namespace app\_360Utils;




class CotizadorSobre{


    function realizaCotizacion($json){
        // Servicios habilitados para la cotización
        //verifica si FEDEX extá disponible
        $useFedex = true;
        //verifica si DGOM extá disponible
        $useDgom = false;
        //Verifica si usa UPS
        $useUPS = true;

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

        if($useUPS){
            $res = $this->cotizaDocumentoUPS($json);
            if($res != null){
                $data = array_merge($data, $res);
            }
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



    // ----------------------------- COTIZACION UPS ----------------------------------------
    private function cotizaDocumentoUPS($json){
        $ups = new UpsServices();
        $fecha = "";
        $cotizaciones = $ups->cotizarEnvioDocumento($json->cp_origen, "CA", $json->pais_origen, $json->cp_destino, "UT" , $json->pais_destino, $fecha, $json->peso_kilogramos);

        return $cotizaciones;
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
}

?>