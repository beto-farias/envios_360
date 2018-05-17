
// Initialize Firebase
var config = {
    apiKey: "AIzaSyAEdRVnYpqZp8KPDMXYb0_0XOnj2L5RsUA",
    authDomain: "fir-84971.firebaseapp.com",
    databaseURL: "https://fir-84971.firebaseio.com",
    projectId: "fir-84971",
    storageBucket: "fir-84971.appspot.com",
    messagingSenderId: "59037192877"
};
firebase.initializeApp(config);

var provider = new firebase.auth.FacebookAuthProvider();
var nombre;
var correo;
var password;
var form;
var logout;
var formLogin;
var buttonFacebook;

function loginFacebook() {
    firebase.auth().signInWithPopup(provider).then(function(result) {
        // This gives you a Facebook Access Token. You can use it to access the Facebook API.
        var token = result.credential.accessToken;
        // The signed-in user info.
        var user = result.user;
        if(user){
            crearCuentaSever(user.email, user.displayName, user.uid);
        }
        // ...
      }).catch(function(error) {
        // Handle Errors here.
        var errorCode = error.code;
        var errorMessage = error.message;
        // The email of the user's account used.
        var email = error.email;
        // The firebase.auth.AuthCredential type that was used.
        var credential = error.credential;
        console.log(errorCode);
        existeCuenta(errorCode);
        // ...
      });
}

function redirect() {
    firebase.auth().getRedirectResult().then(function (result) {
        if (result.credential) {
            // This gives you a Facebook Access Token. You can use it to access the Facebook API.
            var token = result.credential.accessToken;
            // ...
        }
        // The signed-in user info.
        var user = result.user;

        if(user){
            swal("Cargando", "Cargando usuario", "success");
            $.ajax({
                url: baseUrl + "site/guardar-cliente",
                method: "POST",
                data: {
                    email: user.email,
                    nombre: user.displayName,
                    uddi: user.uid,
                },
                success: function (r) {
    
                },
                error: function () {
                    
                }
    
            }); 
        }

    }).catch(function (error) {
        // Handle Errors here.
        var errorCode = error.code;
        var errorMessage = error.message;
        // The email of the user's account used.
        var email = error.email;
        // The firebase.auth.AuthCredential type that was used.
        var credential = error.credential;
        console.log(error.message);
        // ...
    });
}

function signOut() {
    firebase.auth().signOut().then(function () {
        // Sign-out successful.
        window.location.href = baseUrl + "site/logout";
    }).catch(function (error) {
        // An error happened.
    });
}

function statusUsuario() {
    firebase.auth().onAuthStateChanged(function (user) {
        if (user) {
           // ingresar(user.uid);
            // ...
        } else {
            console.log("no hay session");
            // User is signed out.
            // ...
        }
    });
}

function crearCuenta(email, password) {
    firebase.auth().createUserWithEmailAndPassword(email, password).catch(function (error) {


        // Handle Errors here.
        var errorCode = error.code;
        var errorMessage = error.message;
        existeCuenta(errorCode);

    }).then(function (user) {
        
        crearCuentaSever(correo.val(), nombre.val(), user.uid);

    });
}

function existeCuenta(errorCode){
    if (errorCode == "auth/email-already-in-use") {
        swal("Espera", "Ya existe una cuenta asociada con el email ingresado", "warning");
        return false;
     }else if(errorCode == "auth/account-exists-with-different-credential"){
        swal("Espera", "La cuenta ya existe con un diferente inicio de sesión", "warning");
     }
}

function crearCuentaSever(correP, nombreP, uidP){
    $.ajax({
        url: baseUrl + "site/guardar-cliente",
        method: "POST",
        data: {
            email: correP,
            nombre: nombreP,
            uddi: uidP,
        },
        success: function (r) {

        },
        error: function () {
            
        }

    });
}

function ingresar(uddi){
    window.location.href = baseUrl + "site/ingresar?token="+uddi;
}

function recuperarPass(emailAddress){
    var auth = firebase.auth();
emailAddress = "humberto@2gom.com.mx";

auth.sendPasswordResetEmail(emailAddress).then(function() {
  // Email sent.
}).catch(function(error) {
  // An error happened.
});
}

function signIn(email, password) {
    firebase.auth().signInWithEmailAndPassword(email, password).catch(function (error) {

        
        // Handle Errors here.
        var errorCode = error.code;
        var errorMessage = error.message;
    
        if(errorCode=="auth/user-not-found"){
            swal("Espera", "No existe una cuenta asociada al correo electrónico ingresado", "warning");
            return false;
        }
        // ...
    }).then(function ($user) {
        if($user){
            ingresar($user.uid);
        }    
    });
}

$(document).ready(function () {

    nombre = $("#entclientes-txt_nombre");
    correo = $("#entclientes-txt_correo");
    password = $("#entclientes-password");
    form = $("#form-registro");
    logout = $(".logout");
    formLogin = $("#login-form");
    buttonFacebook = $("#button-facebook")

    form.on("beforeSubmit", function () {

        var status = crearCuenta(correo.val(), password.val());


        return false;
    });

    buttonFacebook.on("click", function(e){
        e.preventDefault();
        loginFacebook();
    });

    formLogin.on("beforeSubmit", function () {
        signIn(correo.val(), password.val());

        return false;
    });

    logout.on("click", function (e) {
        e.preventDefault();
        signOut();
    })

});

statusUsuario();
