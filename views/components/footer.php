<?php
use yii\helpers\Url;
?>

<footer role="contentinfo" class="nav-footer">
    <div class="container-1220">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                <nav class="nav-footer-navigation">
                    <h4>Información & Ayuda</h4>
                    <a href="<?=Url::base()?>/site/aviso-privacidad">Aviso de Privacidad</a>
                    <a href="<?=Url::base()?>/site/terminos-condiciones">Términos y Condiciones</a>
                </nav>
                <nav class="nav-footer-navigation">
                    <a href="<?=Url::base()?>/site/preguntas-frecuentes">Preguntas Frecuentes</a>
                    <a href="#">Ayuda</a>
                </nav>
            </div>
            <div class="col-12 col-sm-12 col-md-4 col-lg-4 d-flex align-items-center">
                <a class="btn btn-secondary nav-footer-downloadapp" target="_self" href="">
                    <i class="ion ion-iphone"></i> ¡Descarga gratis la app!
                </a>
                <!-- <div class="nav-footer-certificado">
                    <p>Certificado de SSL</p>
                    <i class="ion ion-ios-locked"></i>
                </div> -->
            </div>
        </div>
        <div class="nav-footer-row">
                <div class="nav-footer-copyright">
                    <small>LatinGal Boutique 2018.</small>
                </div>
                <div class="nav-footer-certificado">
                    <img class="logo-secure" src="<?=Url::base()?>/webAssets/images/secure-logo.png" alt="">
                    <img class="logo-openpay" src="<?=Url::base()?>/webAssets/images/openpay-logo.png" alt="">
            </div>
        </div>
    </div>
</footer>