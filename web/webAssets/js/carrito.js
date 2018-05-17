
$(document).ready(function(){

    getTiempoCarrito();
});

function getTiempoCarrito(){
    $.ajax({
        url:baseUrl+"site/get-tiempo-carrito",
        success:function(r){
            if(r.status=="success"){
                
                countDown(r.result.seconds_2_delete);
            }else{
                // swal({
                //     title: "Espera",
                //     text: "El carrito ha expirado",
                //     type: "warning",
                //     showCancelButton: false,
                //     confirmButtonClass: "btn-warning",
                //     confirmButtonText: "Ok",
                //     closeButtonText: "No",
                //     closeOnConfirm: true,
                //     //closeOnCancel: false
                //   },
                //   function() {
                //     location.reload();
                //   });
    
            }
            
        }
    });
}

function countDown(seconds){
    var segundos = seconds;
    setInterval(function() {
        
        segundos--;
        getTime(segundos);
    }, 1000);
}

function getTime(seconds){
   
    var days = Math.floor(seconds / (3600*24));
    seconds  -= days*3600*24;
    var hrs   = Math.floor(seconds / 3600);
    seconds  -= hrs*3600;
    var mnts = Math.floor(seconds / 60);
    seconds  -= mnts*60;


    $("#dias span").text(days);
    $("#horas span").text(hrs);
    $("#minutos span").text(mnts);
    $("#segundos span").text(seconds);
    $(".loading-time").hide();
    $(".tiempo-restantes").show();
   // console.log(days+" Días, "+hrs+" Horas, "+mnts+" Minutos, "+seconds+" Segundos");

    

}