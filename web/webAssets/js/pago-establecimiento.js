$(document).ready(function() {

    // Click en input de código de seguridad - Flip
    $( "#js-btn-print" ).on("click", function(e) {
        e.preventDefault();

        var mode = 'iframe'; //popup
        var close = mode == "popup";
        var options = { mode : mode, popClose : close};
        $("#js-ticket-print").printArea( options );

        // $("#js-ticket-print").printArea();

        // var ficha = document.getElementById('js-ticket-print');
        // var ventimp=window.open(' ','popimpr');
        // ventimp.document.write(ficha.innerHTML);
        // ventimp.document.close();
        // ventimp.print();ventimp.close();
    });

    $(".js-imprimir").on("click", function(e){
        e.preventDefault();
        var elemento = $(this);
        var token = $(this).data("token");

        var mode = 'iframe'; //popup
        var close = mode == "popup";
        var options = { mode : mode, popClose : close};
        $(token).printArea( options );
    })

    $(".js-mostrar-ticket").on("click", function(e){
        e.preventDefault();
        var elemento = $(this);
        var token = $(this).data("token");

        $(".js-item").hide();
        $(token).show();
    })
        
});