<?php $pag_actual = "Inicio";?>
<?php include("./templates/header.php"); ?>
<?php $url_base="http://localhost/NEGOCIO-SISTEMA"; ?>
    <head>
        <link rel="stylesheet" href="./Style/SISTEM/index.css">
    </head>
    <article class="main__article">
        <section class="main__paragraph">
            <h1 class="main__h1">Bienvenid@ <?php echo $_SESSION['usuario']?>.<br class="br"> Elija una opción</h1>
        </section>
        <section class="main__opciones">
            <div class="opcion">
                <figure class="opcion__figure">
                    <img src="<?php echo $url_base;?>/assets/bolsa-de-la-compra.webp" alt="" class="opcion__img">
                </figure>
                <div class="opcion__paragraph">
                    <a href=" <?php echo $url_base; ?>/ventas/crear.php" class="opcion__cta">Agregar Venta</a>
                    <p class="opcion__p">Hacer una venta al contado.</p>
                </div>
            </div>
            <div class="opcion">
                <figure class="opcion__figure">
                    <img src="<?php echo $url_base;?>/assets/agregar-paquete.webp" alt="" class="opcion__img">
                </figure>
                <div class="opcion__paragraph">
                    <a href="<?php echo $url_base; ?>/productos/crear.php" class="opcion__cta">Agregar producto</a>
                    <p class="opcion__p">Almacena tus productos.</p>
                </div>
            </div>
            <div class="opcion">
                <figure class="opcion__figure">
                    <img src="<?php echo $url_base;?>/assets/grupo.png" alt="" class="opcion__img">
                </figure>
                <div class="opcion__paragraph">
                    <a href="<?php echo $url_base;?>/usuarios/index.php" class="opcion__cta">Inventario de Usuarios</a>
                    <p class="opcion__p">Manten un inventario de compras.</p>
                </div>
            </div>
            <div class="opcion">
                <figure class="opcion__figure">
                    <img src="<?php echo $url_base;?>/assets/agregar-usuario.webp" alt="" class="opcion__img">
                </figure>
                <div class="opcion__paragraph">
                    <a href="<?php echo $url_base;?>/usuarios/crear.php" class="opcion__cta">Agregar usuario</a>
                    <p class="opcion__p">Registra usuarios nuevos.</p>
                </div>
            </div>
            <div class="opcion">
                <figure class="opcion__figure">
                    <img src="<?php echo $url_base;?>/assets/reporte.webp" alt="" class="opcion__img">
                </figure>
                <div class="opcion__paragraph">
                    <a href="<?php echo $url_base;?>/ventas/" class="opcion__cta">Registro de ventas</a>
                    <p class="opcion__p">Accede a tu lista de ventas.</p>
                </div>
            </div>
            <div class="opcion">
                <figure class="opcion__figure">
                    <img src="<?php echo $url_base;?>/assets/inventario.webp" alt="" class="opcion__img">
                </figure>
                <div class="opcion__paragraph">
                    <a href="<?php echo $url_base;?>/productos/index.php" class="opcion__cta">Inventario de productos</a>    
                    <p class="opcion__p">Lleva un control de tus productos.</p>
                </div>
            </div>
        </section>
    </article>
<?php include("./templates/footer.php") ?>