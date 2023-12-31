<?php
    session_start();
    $url_base="http://localhost/NEGOCIO-SISTEMA";
    if(!isset($_SESSION['usuario'])){
        header("Location:".$url_base."/login.php");
    }else{

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="/NEGOCIO-SISTEMA/Style/SISTEM/style.css">
    <link rel="stylesheet" href="/NEGOCIO-SISTEMA/Style/header.css">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous"
    />
    <script
        src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <header class="header">
        <nav class="header__nav">
            <section class="nav__logo">
                <a href="#" class="nav__cta nav__cta--item1">
                    <figure class="cta__figure">
                        <img src="<?php echo $url_base;?>/assets/barra-de-menus.png" alt="" class="cta__img">
                    </figure>
                </a>
                <figure class="nav__figure">
                    <img src="<?php echo $url_base;?>/assets/logo.png" alt="" class="nav__img">
                </figure>
                <div class="nav__ubicacion">
                    <p class="p">Inicio/ <strong><?php echo $pag_actual?></strong></p>
                </div>
            </section>
            <section class="header__usuario">
                <div class="usuario__paragraph">
                    <h3 class="usuario__name"><?php echo $_SESSION['usuario'];?></h3>
                </div>
                <figure class="usuario__figure">
                    <img src="/NEGOCIO-SISTEMA/assets/usuario.png" alt="" class="usuario__img">
                </figure>
            </section>
        </nav>
        <aside class="aside__bar">
            <section class="aside__li">
                <a href="<?php echo $url_base;?>/index.php" class="aside__cta aside__cta--item1">
                    <figure class="aside__figure">
                        <img src="<?php echo $url_base;?>/assets/hogar.png" alt="" class="aside__img">
                    </figure>
                    <div class="aside__paragraph">
                        <p class="paragraph">Inicio</p>
                    </div>
                </a>
                <a href="<?php echo $url_base;?>/ventas" class="aside__cta aside__cta--item1">
                    <figure class="aside__figure">
                        <img src="<?php echo $url_base;?>/assets/incrementar.png" alt="" class="aside__img">
                    </figure>
                    <div class="aside__paragraph">
                        <p class="paragraph">Ventas</p>
                    </div>
                </a>
                <a href="<?php echo $url_base;?>/productos/index.php" class="aside__cta aside__cta--item2">
                    <figure class="aside__figure">
                        <img src="<?php echo $url_base;?>/assets/carrito-de-compras.png" alt="" class="aside__img">
                    </figure>
                    <div class="aside__paragraph">
                        <p class="paragraph">Compras</p>
                    </div>
                </a>
                <a href="<?php echo $url_base;?>/usuarios/index.php" class="aside__cta aside__cta--item3">
                    <figure class="aside__figure">
                        <img src="<?php echo $url_base;?>/assets/usuario (2).png" alt="" class="aside__img">
                    </figure>
                    <div class="aside__paragraph">
                        <p class="paragraph">Usuarios</p>
                    </div>
                </a>
                <a href="<?php echo $url_base?>/cerrar.php" class="aside__cta aside__cta--item4">
                    <figure class="aside__figure">
                        <img src="<?php echo $url_base;?>/assets/cerrar-sesion.png" alt="" class="aside__img">
                    </figure>
                    <div class="aside__paragraph">
                        <p class="paragraph">Cerrar Sesión</p>
                    </div>
                </a>
            </section>
        </aside>
    </header>
    <main>
    <?php if(isset($_GET['mensaje'])){ ?>
        <script>
            Swal.fire({icon:"success",title:"<?php echo $_GET['mensaje']; ?>"});
        </script>
    <?php } ?>