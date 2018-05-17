$(document).ready(function() {
    $(".js-delete-direccion").on('click', function(){
        var uddi = $(this).data('uddi');
        var url = $(this).data('url');


        swal({
            title: "Espera",
            text: "¿Estas seguro de eliminar esta dirección?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-warning",
            confirmButtonText: "Sí, eliminar dirección",
            closeButtonText: "No",
            closeOnConfirm: true,
            //closeOnCancel: false
          },
          function() {
            $.ajax({
                url: url+"/site/eliminar-direccion?uddi="+uddi,
                success: function(resp){
                    if(resp.status == 'success'){
                        $(".js-direccion-"+uddi).remove();
                    }
                }
            });
          });

        
    });     
    
    
    $(".js-envio").on("click", function(e){
        e.preventDefault();
        var token = $(this).data("token");

        $("#tipoEntrega").val(token);

        $(".js-envio").addClass("shipping-add-item-disabled");
        $(this).removeClass("shipping-add-item-disabled");
        
        $("#form-direccion").attr("action", "direccion");
        $("#form-direccion").submit();
    })

    $(".continuar-pago").on("click", function(e){
        e.preventDefault();
        if($("#direccionEntrega").val()==""){
            swal("Espera", "Debes agregar una dirección para la entrega", "warning");
        }else{
            $("#form-direccion").submit();
        }
    })

    $(".js-seleccionar-direccion").on("click", function(e){
        e.preventDefault();
        var elemento = $(this);
        var token  = elemento.data("uddi");
        var cp = elemento.data("cp");
        var calle = elemento.data("calle");
        var colonia = elemento.data("colonia");
        var municipio = elemento.data("municipio");

        $("#direccionEntrega").val(token);
        var template = '<div class="hero-addres">'+
                            '<span>C.P. '+cp+'</span>'+
                            '<p>'+calle+' - '+colonia+' - '+municipio+'</p>'+
                        '</div>';
        $(".contenedor-direccion").html(template);

        $("#modal-direcciones").modal("hide");
    });


});