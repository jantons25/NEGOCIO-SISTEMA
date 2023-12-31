<?php include("../bd.php");

    $pag_actual =  "Usuarios";

    $sentencia_rol = $conexion->prepare("SELECT * FROM `tbl_rol`");
    $sentencia_rol->execute();
    $lista_tbl_rol=$sentencia_rol->fetchAll(PDO::FETCH_ASSOC);

    if($_POST){ 
        
        $nombre=(isset($_POST["nombre"])?$_POST["nombre"]:"");
        $password=(isset($_POST["contrasenia"])?$_POST["contrasenia"]:"");
        $rol=(isset($_POST["rol"])?$_POST["rol"]:"");
        $estado=(isset($_POST["estado"])?$_POST["estado"]:"");
        $telefono=(isset($_POST["telefono"])?$_POST["telefono"]:"");

        foreach($lista_tbl_rol as $registro){
            if($registro["id_rol"]==$rol){
                $id_rol = $registro["id_rol"];
            }
        }

        $sentencia_usuario=$conexion->prepare("INSERT INTO `tbl_usuarios` (`id_usuario`, `id_rol`, `nombre_usuario`, `password`,`estado`, `telefono`) 
            VALUES (NULL,:id_rol,:nombre_usuario,:password,:estado,:telefono);");
        $sentencia_usuario->bindParam(":id_rol",$id_rol);
        $sentencia_usuario->bindParam(":nombre_usuario",$nombre);   
        $sentencia_usuario->bindParam(":password",$password);
        $sentencia_usuario->bindParam(":estado",$estado);    
        $sentencia_usuario->bindParam(":telefono",$telefono); 
        $sentencia_usuario->execute();

        $mensaje = "Registro Agregado";
        header("Location:index.php?mensaje=".$mensaje);
    }
?>
<?php include("../templates/header.php") ?>
<?php $url_base="http://localhost/NEGOCIO-SISTEMA"; ?>
<head>
    <link rel="stylesheet" href="<?php echo $url_base?>/Style/PRODUCTOS/style.css">
</head>
<section class="form__crear form__crear__producto">
    <div class="form__crear__title">
        <h1 class="form__crear__h1">Datos del Usuario</h1>
    </div>
    <form action="" method="post" enctype="multipart/form-data" class="form">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Nombre del usuario">
        </div>
        <div class="mb-3">
            <label for="contrasenia" class="form-label">Contraseña</label>
            <input type="text" name="contrasenia" class="form-control" id="contrasenia" placeholder="Password">
        </div>
        <div class="mb-3">
            <label for="rol" class="form-label">Rol</label>
            <select class="form-select" aria-label="Default select example" name="rol" id="rol">
                <?php foreach($lista_tbl_rol as $registro){ ?>
                    <option value=" <?php echo $registro['id_rol'];?> "> <?php echo $registro['nombre'];?> </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select class="form-select" aria-label="Default select example" name="estado" id="estado">
                <option selected value="Activo">Activo</option>
                <option value="Desactivado">Desactivado</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" name="telefono" class="form-control" id="telefono" placeholder="Teléfono">
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn__form">Enviar</button>
            <a name="btncancelar" id="btncancelar" class="btn btn-danger" href="index.php" role="button">Cancelar</a>
        </div>
    </form>
</section>
<?php include("../templates/footer.php") ?>