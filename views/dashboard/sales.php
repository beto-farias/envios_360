<ul>
<?php foreach($ventas as $item): ?>
    <li>
        <?=$item->uddi?>
        Cliente: <?=$item->idCliente->txt_nombre?>
        Fecha de venta: <?=$item->fch_venta?>
        Monto: $<?=$item->idOpenpayPayment->amount?>
        Autorización: <?=$item->idOpenpayPayment->authorization?>
    </li>
<?endforeach?>
</ul>