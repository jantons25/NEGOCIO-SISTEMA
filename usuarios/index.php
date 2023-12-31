<?php include("../bd.php"); 

    $pag_actual =  "Usuarios";

    $sentencia = $conexion->prepare("SELECT *,(SELECT nombre FROM tbl_rol WHERE tbl_rol.id_rol = tbl_usuarios.id_rol limit 1) as rol FROM `tbl_usuarios`");
    $sentencia->execute();
    $lista_tbl_usuarios=$sentencia->fetchAll(PDO::FETCH_ASSOC);

    if(isset($_GET['txtID'])){ 
        $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";

        $sentencia=$conexion->prepare("DELETE FROM tbl_usuarios WHERE id_usuario=:id_usuario");
        $sentencia->bindParam(":id_usuario",$txtID);   
        $sentencia->execute();

        $mensaje = "Registro eliminado";
        header("Location:index.php?mensaje=".$mensaje);
    }
?>
<?php include("../templates/header.php"); ?>
<head>
    <link rel="stylesheet" href="<?php echo $url_base;?>/Style/VENTAS/index.css">
</head>
<section class="section__ventas__index">
    <article class="agregar__venta">
        <a name="" id="" class="btn btn-primary" href="crear.php" role="button">Agregar Usuario</a> 
    </article>
    <section class="venta__table">
        <table class="table table-striped" id="tabla_id">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Rol</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Contraseña</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Teléfono</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($lista_tbl_usuarios as $registro){?>
                <tr>
                    <th scope="row"><?php echo $registro['id_usuario'];?></th>
                    <td><?php echo $registro['rol'];?></td>
                    <td><?php echo $registro['nombre_usuario'];?></td>
                    <td>******</td>
                    <td><?php echo $registro['estado'];?></td>
                    <td><?php echo $registro['telefono'];?></td>
                    <td>
                        <a name="btneditar"  id="btneditar" class="btn btn-info" href="editar.php?txtID=<?php echo $registro['id_usuario']; ?>" role="button">Editar</a>
                        <a name="btnborrar"  id="btnborrar" class="btn btn-danger" href="javascript:borrar(<?php echo $registro['id_usuario']; ?>)" role="button">Eliminar</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </section>
</section>
<?php include("../templates/footer.php"); ?>