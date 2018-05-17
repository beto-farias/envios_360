<?php
use yii\helpers\Html;
use yii\web\View;
use yii\helpers\Url;
use app\config\S3Config;
?>

<div class="aside-container aside-container-hv">
		
	<div class="aside-header">
		<h3 class="aside-title">
			Tu carrito
		</h3>
	</div>

	<?php
	if(count($listaCarrito->results)==0){
		echo '<p class="aside-null">Tu carrito esta vacío</p>';
	}else{
		$subTotal = 0;
		$total = 0;
		
		foreach($listaCarrito->results as $producto){
			$subTotal += ($producto->int_cantidad * $producto->id_producto->num_precio);
			$total += ($producto->int_cantidad * $producto->id_producto->num_precio);
		}
		$total = $subTotal + ($envio->data["total"]*100);
	?>

		<div class="aside-costo">
			
			<div class="aside-costo-item">
				<span>SubTotal</span>
				<p><b>$</b> <?=number_format(($subTotal/100), 2, ".", ",")?> <small>MXN</small></p>
			</div>
			<div class="aside-costo-item">
				<span>Envio</span>
				<p><b>$ <?=number_format($envio->data["total"], 2, ".", ",")?><small>MXN</small></p>
			</div>
			<div class="aside-costo-item aside-costo-item-total">
				<span>Total</span>
				<p><b>$</b> <?=number_format(($total/100), 2, ".", ",")?> <small>MXN</small></p>
			</div>
		</div>

		<div class="aside-details">
			<div class="aside-details-head">
				<!-- <span class="aside-details-save">Guardar carrito</span> -->
				<a href="<?=Url::base()?>/site/carrito" class="aside-details-edit">Editar carrito</a>
			</div>
			<div class="aside-details-body">

				<?php
				foreach($listaCarrito->results as $producto){?>
					<div class="aside-details-item">
						<div class="aside-details-item-desc">
							<div class="aside-details-item-desc-img">
								<?php
								if(count($producto->id_producto->producto_data["imagenes"])>0){
									$urlImg =  S3Config::BASE_URL . S3Config::URL_PRODUCTOS . $producto->id_producto->producto_data["imagenes"][0]->txt_url_imagen;
								}else{
									$urlImg =  "https://s3.us-east-2.amazonaws.com/latingal-imgs-s3/productos/poster_holder.png";
								}
								?>
								
								<img src="<?=$urlImg?>" alt="">
							</div>
							<div class="aside-details-item-desc-txt">
								<p><?=$producto->id_producto->txt_nombre?></p>
								<span>Talla <?=$producto->id_talla->txt_nombre?></span>
							</div>
						</div>
						<div class="aside-details-item-count">
							<p class="aside-details-item-count-item"><?=$producto->int_cantidad?></p>
						</div>
					</div>
				<?php
				}
				?>

			</div>
		</div>
	<?php
	}
	?>
</div>