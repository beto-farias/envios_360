<?php

?>

<h1>Envío recibido correctamente</h1>
<strong>Código de envío:</strong> <?=$model->txt_envio_code?><br>
<strong>Tipo de empaque:</strong> <?=$model->txt_tipo_empaque?><br>
<strong>Tipo de servicio:</strong> <?=$model->txt_tipo_servicio?><br>
<strong>Tipo de servicio:</strong> <?=$model->txt_monto_pago?><br>
<strong>Tipo de servicio:</strong> <?=$model->txt_monto_iva?><br>
<strong>Tipo de moneda:</strong> <?=$model->txt_tipo_moneda?><br>
<strong>Descargar etiqueta:</strong> <a href="site/download-label?uuid=<?=$model->uuid ?>">Aqui</a>

