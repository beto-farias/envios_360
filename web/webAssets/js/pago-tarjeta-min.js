$(document).ready(function(){function o(){$(".hero-pago-tarjeta-form-card").addClass("flipped")}function a(){$(".hero-pago-tarjeta-form-card").removeClass("flipped")}$("#hero-pago-tarjeta-form-codigo-seguridad").on("click",function(){""==$(this).val()&&o()}),$("#hero-pago-tarjeta-form-codigo-seguridad").on("change",function(){a()}),$("#hero-pago-tarjeta-form-codigo-seguridad").focusout(function(){a()})});