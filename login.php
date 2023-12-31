<?php
    session_start();
    include ("./bd.php");
    if($_POST){
        $sentencia = $conexion->prepare("SELECT *,count(*) as n_usuarios FROM `tbl_usuarios` WHERE nombre_usuario=:nombre_usuario AND password=:password");
        
        $usuario=$_POST["usuario"];
        $contrasenia=$_POST["password"];

        $sentencia->bindParam(":nombre_usuario",$usuario);
        $sentencia->bindParam(":password",$contrasenia);
        $sentencia->execute();
        $registro=$sentencia->fetch(PDO::FETCH_LAZY);

        if($registro["n_usuarios"]>0){
            $_SESSION['usuario']=$registro["nombre_usuario"];
            $_SESSION['logueado']=true;
            header("Location:index.php");
        }else{
            $mensaje="Error: El usuario o contraseña son incorrectos";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./Style/LOGIN/style.css">
    <link rel="stylesheet" href="./Style/SISTEM/style.css">
</head>
<body>
    <article class="login__article">
        <section class="login__banner">
            <h2>Sistema de Ventas</h2>
            <figure class="login__figure">
                <img src="./assets/undraw_predictive_analytics_re_wxt8.svg" alt="" class="login__img">
            </figure>
        </section>
        <section class="login__iniciar">
            <?php if(isset($mensaje)){ ?>
                <div class="alert alert-danger" role="alert">
                    <strong> <?php echo $mensaje; ?> </strong>
                </div>
            <?php }?>
            <form class="login__form" method="post">
                <figure class="iniciar__figure">
                    <img src="./assets/usuario.png" alt="" class="iniciar__img">
                </figure>
                <label for="title" class="title">Iniciar Sesión</label>
                <input type="text" class="login__input__usuario" name="usuario" placeholder="Usuario" id="name">
                <input type="password" class="login__input__password" name="password" id="password" placeholder="Contraseña">
                <div class="login__recordar">
                    <input type="checkbox" name="recordar" id="recordar" class="login__input__recordar">
                    <label for="recordar" class="recordar__label">Recordar datos</label>
                </div>
                <button type="submit" class="login__button" name="iniciar" >Iniciar Sesión</button>
                <a href="#" class="login__cta">¿Olvidaste tu contraseña?</a>
            </form>
        </section>
    </article>

    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"
    ></script>
    
</body>
</html>