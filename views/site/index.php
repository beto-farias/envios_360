<?php 
use yii\helpers\Url;


?>




<form method="POST" class="form-group">
<div class="container">
    
        <div class="row">    
                <input id="form-token" type="hidden" name="
use yii\helpers\Url;

use yii\helpers\Url;
<?=Yii::$app->request->csrfParam?>" value="<?=Yii::$app->request->csrfToken?>"/>
                
                <div class=" col-md-2">
                    <label for="cp_origen">CP origen</label>
                    <input class="form-control" id="cp_origen" name="cp_origen" value="53240">
                </div>
                <div class=" col-md-2">
                    <label for="pais_origen">Pais origen</label>
                    <input class="form-control" id="pais_origen" name="pais_origen" value="MX">
                </div>
                <div class=" col-md-2">
                    <label for="cp_origen">CP destino</label>
                    <input class="form-control" id="cp_destino" name="cp_destino" value="08500">
                </div>
                <div class=" col-md-2">
                    <label for="cp_origen">Pais origen</label>
                    <input class="form-control" id="pais_destino" name="pais_destino" value="MX">
                </div>
                <div class=" col-md-2">
                    <input class="form-control btn btn-primary" type="button" id="button" value="Cotizar">
                </div>
        </div>    
      
</div>
</form> 


<div class="container">
    <div class="row">
        <div class="col-md-12">
            Origen: <span id="txt_cp_origen"></span>
            Destino: <span id="txt_cp_destino"></span>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <table id="content" class="table">
                <th>
                    <tr>
                        <td>proveedor</td>
                        <td>Tipo de servicio</td>
                        <td>Fecha de entrega</td>
                        <td>Precio</td>
                        <td>IVA</td>
                        <td>Moneda</td>
                        <td>Acciones</td>

                    </tr>
                </th>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $("#button").click(function(){

var url = "http://localhost/2018/envios_360/web/services/request-cotizacion-documento";


        var cpOrigen    = $("#cp_origen").val();
        var cpDestino   = $("#cp_destino").val();
        var paisOrigen  = $("#pais_origen").val();
        var paisDestino = $("#pais_destino").val();

        $("#txt_cp_origen").html(cpOrigen + " " + paisOrigen);
        $("#txt_cp_destino").html(cpDestino + " " + paisDestino);

        createRequestObject = {
            "cp_origen":cpOrigen,
            "pais_origen":paisOrigen,
            "cp_destino":cpDestino,
            "pais_destino":paisDestino,
            "peso_gramos":0.5
        };

        $.ajax({
            type: "POST",
            beforeSend: function(request) {
                request.setRequestHeader("api-key", "key");
                request.setRequestHeader("api-secret", "secret");
            },
            url: url,
            data:  JSON.stringify(createRequestObject),
            dataType: "json",
            processData: false,
            contentType: 'application/json' ,
            success: function(msg,status,xhr) {
                console.log("success: " + msg);

                for(i=0; i < msg.length; i++){
                    cotizacion = msg[i]; 
                    console.log(i);
                    console.log(cotizacion);
                    row = "<tr>";
                    row += "<td>" + cotizacion['provider'] + "</td>";
                    row += "<td>" + cotizacion['serviceType'] + "</td>";
                    row += "<td>" + cotizacion['deliveryDate'] + "</td>";
                    row += "<td>" + cotizacion['price'] + "</td>";
                    row += "<td>" + cotizacion['tax'] + "</td>";
                    row += "<td>" + cotizacion['currency'] + "</td>";
                    row += "<td><a  href='<?=Url::base()?>/site/purchase?carrier=" + cotizacion['provider'] + 
                            "&service_type=" + cotizacion['serviceType'] + 
                            "&cpOrigen=" + cpOrigen + 
                            "&paisOrigen=" + paisOrigen + 
                            "&cpDestino=" + cpDestino + 
                            "&paisDestino=" + paisDestino + 
                            "'>Comprar</a></td>";
                    row += "</tr>";
                    console.log(row);
                    $("#content").append(row);
                }
            },
            error: function(msg){
                alert(msg);
            }
            });
    

        
        

});
</script>