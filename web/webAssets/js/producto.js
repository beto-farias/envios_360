var owl;

function destroyZoom(){
    $('.zoomContainer').remove();
    $('#carousel-products .owl-item.active img').removeData('elevateZoom');
    $('#carousel-products .owl-item.active img').removeData('zoomImage');
}

function initZoom(){
    $('#carousel-products .owl-item.active img').elevateZoom();
}

function validarInventario(){
   
}

$(document).ready(function() {

    $("#comprar-ahora").on("click", function(e){
        e.preventDefault();

        var token = $("#inlineFormCustomSelect").val();
        var tokenProducto = $("#uddi-producto").val();
        var cantidad = $("#inlineFormCustomSelectCantidad").val();
    
        if(cantidad==""){
            swal("Espera", "Debes agregar una cantidad", "warning");
            return false;
        }
        if(cantidad > 9 || cantidad < 1){
            swal("Espera", "Debes agregar una cantidad de entre 1 y 9 productos", "warning");
            return false; 
        }

        $.ajax({
            url:baseUrl+"site/validar-inventario?uddi="+token+"&uddip="+tokenProducto,
            success:function(r){
                if(r.status =="success"){
                    var cantidad = $("#inlineFormCustomSelectCantidad").val();
                    if(parseInt(r.result.data.count)< cantidad){
                        swal("Espera", "Solo existen "+r.result.data.count+" piezas en el inventario", "warning");
                        $("#inlineFormCustomSelectCantidad").val(r.result.data.count);
                       
                    }else{
                        $("#comprar").submit();
                    }
                }
            }
        });
    
    });

    $("#agregar-carrito").on("click", function(e){
        e.preventDefault();

        var token = $("#inlineFormCustomSelect").val();
        var tokenProducto = $("#uddi-producto").val();
    
        if($("#inlineFormCustomSelectCantidad").val()==""){
            swal("Espera", "Debes agregar una cantidad", "warning");
            return false;
        }
        $.ajax({
            url:baseUrl+"site/validar-inventario?uddi="+token+"&uddip="+tokenProducto,
            success:function(r){
                if(r.status =="success"){
                    var cantidad = $("#inlineFormCustomSelectCantidad").val();
                    if(parseInt(r.result.data.count)< cantidad){
                        swal("Espera", "Solo existen "+r.result.data.count+" piezas en el inventario", "warning");
                        $("#inlineFormCustomSelectCantidad").val(r.result.data.count);
                       
                    }else{
                        $.ajax({
                            url:baseUrl+"site/agregar-carrito",
                            method:"POST",
                            data:{
                                cantidad: $("#inlineFormCustomSelectCantidad").val(),
                                producto: $("#uddi-producto").val(),
                                talla: $("#inlineFormCustomSelect").val(),
                            },
                            success:function(r){
                                if(r.status=="success"){
                                    swal("Producto agregado", "Se han agregado los productos al carrito");
                                    getCarrito();
                                }
                            }
                        });
                    }
                }
            }
        });
        
     
    });

    owl = $('.owl-carousel');
    owl.owlCarousel({
        items: 1,
        loop: true,
        autoplay: false,
        margin: 0,
        nav: true,
        rewind: true,
        smartSpeed: 200,
        slideSpeed : 500,
        navText: [
            "<i class='ion ion-chevron-left'></i>",
            "<i class='ion ion-chevron-right'></i>"
        ]
    });

    var sync1 = $("#sync1");
    var sync2 = $("#owldos");
    var slidesPerPage = 4; //globaly define number of elements per page
    var syncedSecondary = true;

    owld = $('.owl-carousel-dos');
    owld.owlCarousel({
        loop: false,
        margin: 16,
        nav: true,
        autoplay: false,
        smartSpeed: 200,
        slideSpeed : 500,
        slideBy: slidesPerPage,
        responsiveRefreshRate : 100,
        navText: [
            "<i class='ion ion-chevron-left'></i>",
            "<i class='ion ion-chevron-right'></i>"
        ],
        responsive:{
            0:{
                items:1
            },
            600:{
                items:2
            },
            1000:{
                items:4
            }
        }
    });
    

    // CAROUSEL PRODUCT PREVIEW IMAGE 
    // 1) ASSIGN EACH 'DOT' A NUMBER
    dotcount = 1;

    $('.owl-carousel .owl-dot').each(function() {
        $( this ).addClass( 'dotnumber' + dotcount);
        $( this ).attr('data-info', dotcount);
        dotcount=dotcount+1;
    });
    
    // 2) ASSIGN EACH 'SLIDE' A NUMBER
    slidecount = 1;

    $('.owl-carousel .owl-item').not('.cloned').each(function() {
        $( this ).addClass( 'slidenumber' + slidecount);
        slidecount=slidecount+1;
    });
    
    // SYNC THE SLIDE NUMBER IMG TO ITS DOT COUNTERPART (E.G SLIDE 1 IMG TO DOT 1 BACKGROUND-IMAGE)
    $('.owl-carousel .owl-dot').each(function() {

        grab = $(this).data('info');

        slidegrab = $('.slidenumber'+ grab +' img').attr('src');

        $(this).css("background-image", "url("+slidegrab+")");  

    });

    // Click a heart Like
    $( ".js-heart-like" ).on("click", function() {

        if ( $( this ).hasClass( "ion-ios-heart-outline" ) ) {
            $(this).removeClass('ion-ios-heart-outline');
            $(this).addClass('ion-ios-heart');

        }
        else{
            $(this).removeClass('ion-ios-heart');
            $(this).addClass('ion-ios-heart-outline');
            
        }

    });

    // Agregar Zoom cuando se hace un translated
    initZoom();

    // Destruir Zoom cuando se hace un translate
    owl.on('translate.owl.carousel', function(event) {
        destroyZoom();
    });

    // Agregar Zoom cuando se hace un translated
    owl.on('translated.owl.carousel', function(event) {
        initZoom();
    });

    // Destruir Zoom cuando se hace un change
    owl.on('change.owl.carousel', function(event) {
        destroyZoom();
    });

    // Agregar Zoom cuando se hace un changed
    owl.on('changed.owl.carousel', function(event) {
        initZoom();
    });

    // Destruir Zoom cuando se hace un drag
    owl.on('drag.owl.carousel', function(event) {
        destroyZoom();
	});
    
    // Agregar Zoom cuando se hace un dragged
	owl.on('dragged.owl.carousel', function(event) {
        initZoom();
    });
    
});