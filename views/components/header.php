<?php
use yii\helpers\Url;
use app\models\CatCategoriasTiendas;
?>

<header class="shop-header">
    <div class="container-1220">

        <div class="nav-scroller">
            <div class="row">
                <div class="col-3 col-xs-2 col-sm-2 col-md-2">
                    <nav class="nav-logo">
                        <a class="nav-logo-head text-dark" href="<?=Url::base()?>">
                            <img src="<?=Url::base()?>/webAssets/images/logo-latingal-boutique.png" alt="">
                        </a>
                        <a href="" class="nav-user-more"><i class="ion ion-ios-more"></i></a>
                    </nav>
                </div>
                <div class="col-3 col-xs-3 col-sm-3 col-md-3">
                    <nav class="nav-menu">

                        <div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle dropdown-toggle-submenu" type="button" id="dropdownMenuButtons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Catalogo
                            </button>
                            <div class="dropdown-menu dropdown-menu-sub dropdown-menu-left" aria-labelledby="dropdownMenuButtons">
                                <div class="dropdown-menu-cont">
                                    <?php
                                    $categorias = CatCategoriasTiendas::find()->where(['b_habilitado'=>1])->orderBy(' num_orden ASC')->all();
                                    foreach($categorias as $categoria){
                                    ?>
                                        <a href="<?=Url::base()?>/site/categorias?uddi=<?=$categoria->uddi?>"><?= $categoria->txt_nombre ?></a>
                                    <?php
                                    }
                                    ?>
                                    
                                </div>
                            </div>
                        </div>

                        <!-- <a href="<?=Url::base()?>/site/historial" class="nav-user-link">Outfits</a> -->
                        
                    </nav>
                </div>
                <div class="col-6 col-xs-7 col-sm-7 col-md-7">
                    <nav class="nav-user">
                        
                        <?php
                        if(!Yii::$app->user->isGuest){
                            $usuario = Yii::$app->user->identity;
                        ?>
                        <div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle dropdown-toggle-user" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             <?=$usuario->txt_nombre?>
                            </button>
                            <div class="dropdown-menu dropdown-menu-user dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                <div class="dropdown-menu-cont">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-7 pr--0 br-1">
                                            <div class="dropdown-menu-user">
                                                <div class="dropdown-menu-user-dates">
                                                    <!-- <div class="dropdown-menu-user-dates-avatar">
                                                        <img src="http://via.placeholder.com/80x80" alt="">
                                                    </div> -->
                                                    <div class="dropdown-menu-user-dates-name">
                                                        <span>¡Hola, </span>
                                                        <p> <?=$usuario->txt_nombre?></p>
                                                        <!-- <span>!</span> -->
                                                    </div>
                                                    <div class="dropdown-menu-user-dates-level">
                                                        <!-- <span>Nivel 1</span>
                                                        <span> - </span>
                                                        <span>Inicial</span> -->
                                                    </div>
                                                </div>
                                                <div class="dropdown-menu-user-btn">
                                                    <!-- <a href="" class="btn btn-primary">Mi cuenta</a> -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-5 pl--0">
                                            <div class="dropdown-menu-actions">
                                                <a href="<?=Url::base()?>/site/historial">Mis Compras</a>
                                                <a href="<?=Url::base()?>/site/tickets">Mis tickets</a>
                                                <a class="logout">Salir</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <a href="<?=Url::base()?>/site/historial" class="nav-user-link nav-user-link-res">Mis compras</a>
                        <a href="<?=Url::base()?>/site/tickets" class="nav-user-link nav-user-link-res">Mis tickets</a>
                        <a href="" class="nav-user-icon"><i class="ion ion-ios-heart-outline"></i></a> -->
                        <a href="<?=Url::base()?>/site/carrito" class="nav-user-icon"><i class="ion ion-ios-cart-outline"></i><span class="nav-user-icon-count">99</span></a>
                        <?php
                        }else{
                        ?>
                        <a href="<?=Url::base()?>/site/registro" class="nav-user-link">Regístrate</a>
                        <a href="<?=Url::base()?>/site/login" class="nav-user-link">Ingresa</a>
                        <?php
                        }
                        ?>
                        
                        
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>