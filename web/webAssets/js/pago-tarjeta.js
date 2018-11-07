$(document).ready(function() {

    // Click en input de código de seguridad - Flip
    $( "#hero-pago-tarjeta-form-codigo-seguridad" ).on("click", function() {
        if( $(this).val() == '' ){
            addRotate();
        }
        // else{
        //     removeRotate();
        // }
    });
    // Change en input de código de seguridad - Flip
    $('#hero-pago-tarjeta-form-codigo-seguridad').on('change', function(){
        removeRotate();
    });
    // Focus en input de código de seguridad - Flip
    $( "#hero-pago-tarjeta-form-codigo-seguridad" ).focusout(function() {
        removeRotate();
    });

    // Función para agregar Flip
    function addRotate(){
        $('.hero-pago-tarjeta-form-card').addClass('flipped');
    }
    // Función para quitar Flip
    function removeRotate(){
        $('.hero-pago-tarjeta-form-card').removeClass('flipped');
    }
        
});