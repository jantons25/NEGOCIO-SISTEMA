<?php $url_base="http://localhost/NEGOCIO-SISTEMA"; ?>
<?php include("../bd.php");
    $pag_actual =  "Usuarios";

    $sentencia = $conexion->prepare("SELECT * FROM `tbl_rol`");
    $sentencia->execute();
    $lista_tbl_rol=$sentencia->fetchAll(PDO::FETCH_ASSOC);

    if(isset($_GET['txtID'])){ 
        $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";

        $sentencia=$conexion->prepare("SELECT *,
        (SELECT nombre FROM tbl_rol WHERE tbl_usuarios.id_rol = tbl_rol.id_rol limit 1) as nombre_rol
        FROM tbl_usuarios WHERE id_usuario=:id_usuario");
        $sentencia->bindParam(":id_usuario",$txtID);   
        $sentencia->execute();

        $registro=$sentencia->fetch(PDO::FETCH_LAZY);
        $id_rol = $registro["id_rol"];
        $nombre= $registro["nombre_usuario"];
        $password = $registro["password"];
        $estado = $registro["estado"];
        $telefono = $registro["telefono"];

        $estado_actual="";
        if($estado == 'Activo'){
            $estado_actual = "Desactivado";
        }elseif($estado == 'Desactivado'){
            $estado_actual = "Activo";
        }
    }
    if($_POST){ 
        $txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";

        $nombre_usuario=(isset($_POST["nombre"])?$_POST["nombre"]:"");
        $password=(isset($_POST["contrasenia"])?$_POST["contrasenia"]:"");
        $estado=(isset($_POST["estado"])?$_POST["estado"]:"");
        $telefono=(isset($_POST["telefono"])?$_POST["telefono"]:"");
        $id_rol=(isset($_POST["rol"])?$_POST["rol"]:"");

        $sentencia_usuario=$conexion->prepare("UPDATE tbl_usuarios SET id_rol=:id_rol, nombre_usuario=:nombre_usuario, password=:password, estado=:estado, telefono=:telefono
            WHERE id_usuario=:id_usuario");
        $sentencia_usuario->bindParam(":id_usuario",$txtID);
        $sentencia_usuario->bindParam(":id_rol",$id_rol);   
        $sentencia_usuario->bindParam(":nombre_usuario",$nombre_usuario);
        $sentencia_usuario->bindParam(":password",$password);
        $sentencia_usuario->bindParam(":estado",$estado);
        $sentencia_usuario->bindParam(":telefono",$telefono);
        $sentencia_usuario->execute();

        $mensaje = "Registro Actualizado";
        header("Location:index.php?mensaje=".$mensaje);
    }
?>
<?php include("../templates/header.php");?>
<head>
    <link rel="stylesheet" href="<?php echo $url_base?>/Style/PRODUCTOS/style.css">
</head>
<section class="form__crear form__crear__producto">
    <div class="form__crear__title">
        <h1 class="form__crear__h1">Datos del Usuario</h1>
    </div>
    <form action="" method="post" enctype="multipart/form-data" class="form">
        <div class="mb-3">
            <label for="txtID" class="form-label">ID</label>
            <input type="text" name="txtID" readonly class="form-control" id="txtID" value="<?php echo $txtID;?>">
        </div>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" id="nombre" value="<?php echo $nombre;?>">
        </div>
        <div class="mb-3">
            <label for="contrasenia" class="form-label">Contraseña</label>
            <input type="text" name="contrasenia" class="form-control" id="contrasenia" value="<?php echo $password;?>">
        </div>
        <div class="mb-3">
            <label for="rol" class="form-label">Rol</label>
            <select class="form-select" aria-label="Default select example" name="rol" id="rol">
                <?php foreach($lista_tbl_rol as $registro){?>
                    <option <?php echo ($id_rol == $registro['id_rol'])?"selected":"";  ?> value=" <?php echo $registro['id_rol'] ?> "> <?php echo $registro['nombre']?></option>
                <?php }?>
            </select>
        </div>
        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select class="form-select" aria-label="Default select example" name="estado" id="estado">
                <option selected value="<?php echo $estado;?>"><?php echo $estado;?></option>
                <option value="<?php echo $estado_actual;?>"><?php echo $estado_actual;?></option>
            </select>
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" name="telefono" class="form-control" id="telefono" value="<?php echo $telefono;?>">
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn__form">Guardar</button>
            <a name="btncancelar" id="btncancelar" class="btn btn-danger" href="index.php" role="button">Cancelar</a>
        </div>
    </form>
</section>
<?php include("../templates/footer.php") ?>