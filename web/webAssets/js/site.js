$(document).ready(function() {
    
    $('.animsition').animsition({
        inClass: 'fade-in',
        inDuration: 800,
        //linkElement:'a:not([class="no-redirect"])',
        loading: true,
        loadingClass: 'loader-overlay',
        loadingParentElement: 'html',
        //loadingInner: '\n <div class="loader-content">\n  <div class="loader-index">\n </div>\n </div>',
        onLoadEvent: true,
        transition: function(url){},
      });

    // Click para mostrar sweet
    $( ".example-sweet" ).on("click", function(e) {
        e.preventDefault();

        toastr.success('Algo de Lorem!');
        toastr.info('Algo de Lorem!');
        toastr.warning('Algo de Lorem!');
        toastr.error('Algo de Lorem!');

    });

    // Click para mostrar toastr
    $( ".example-toastr" ).on("click", function(e) {
        e.preventDefault();

        var l = Ladda.create(this);
        l.start();
         
        swal(
            'The Internet?',
            'That thing is still around?',
            'question'
        )

    });
        
});

function getCarrito(){
    $.ajax({
        url:baseUrl+"site/count-carrito",
        success:function(r){
            $(".nav-user-icon-count").text(r.result);
        }
    });
}

// Toastr - OPTIONS
toastr.options = {
    "closeButton": false,
    "debug": true,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-top-center",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}

getCarrito();