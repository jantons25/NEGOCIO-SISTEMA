<?php include("../bd.php");

    $pag_actual =  "Ventas";

    $sentencia = $conexion->prepare("SELECT *,
    (SELECT nombre FROM tbl_producto WHERE tbl_producto.id_producto = tbl_detalle_venta.id_producto limit 1) as nombre_producto,
    (SELECT id_venta FROM tbl_venta WHERE tbl_venta.id_detalle_venta = tbl_detalle_venta.id_detalle_venta limit 1) as id_venta_detalle,
    (SELECT fecha FROM tbl_venta WHERE tbl_venta.id_detalle_venta = tbl_detalle_venta.id_detalle_venta limit 1) as id_venta_fecha,
    (SELECT estado FROM tbl_venta WHERE tbl_venta.id_detalle_venta = tbl_detalle_venta.id_detalle_venta limit 1) as id_venta_estado
    FROM `tbl_detalle_venta`");
    $sentencia->execute();
    $lista_tbl_ventas=$sentencia->fetchAll(PDO::FETCH_ASSOC);

    if(isset($_GET['txtID'])){ 
        $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";

        $sentencia = $conexion->prepare("SELECT * FROM `tbl_venta`");
        $sentencia->execute();
        $lista_tbl_venta=$sentencia->fetchAll(PDO::FETCH_ASSOC);

        foreach($lista_tbl_venta as $registro){
            if($registro["id_detalle_venta"]==$txtID){
                $id_venta = $registro["id_venta"];
            }
        }

        $sentencia=$conexion->prepare("DELETE FROM tbl_detalle_venta WHERE id_detalle_venta=:id_detalle_venta");
        $sentencia->bindParam(":id_detalle_venta",$txtID);   
        $sentencia->execute();

        $sentencia=$conexion->prepare("DELETE FROM tbl_venta WHERE id_venta=:id_venta");
        $sentencia->bindParam(":id_venta",$id_venta);   
        $sentencia->execute();

        $mensaje = "Registro eliminado";
        header("Location:index.php?mensaje=".$mensaje);
    }
?>
<?php include("../templates/header.php"); ?>
<?php $url_base="http://localhost/NEGOCIO-SISTEMA"; ?>
<head>
    <link rel="stylesheet" href="<?php echo $url_base;?>/Style/VENTAS/index.css">
</head>
<section class="section__ventas__index">
    <article class="agregar__venta">
        <a name="" id="" class="btn btn-primary" href="crear.php" role="button">Agregar Registro</a> 
    </article>
    <section class="venta__table">
        <table class="table table-striped" id="tabla_id">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Producto</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Total</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($lista_tbl_ventas as $registro){?>
                <tr>
                    <th scope="row"><?php echo $registro['id_venta_detalle'];?></th>
                    <td><?php echo $registro['nombre_producto'];?></td>
                    <td><?php echo $registro['cantidad'];?></td>
                    <td>S/<?php echo $registro['precio'];?></td>
                    <td>S/<?php echo $registro['precio']*$registro['cantidad'];?></td>
                    <td><?php echo $registro['id_venta_fecha'];?></td>
                    <td><?php echo $registro['id_venta_estado'];?></td>
                    <td>
                        <a name="btneditar"  id="btnborrar" class="btn btn-info" href="editar.php?txtID=<?php echo $registro['id_detalle_venta']; ?>" role="button">Editar</a>
                        <a name="btnborrar"  id="btnborrar" class="btn btn-danger" href="javascript:borrar(<?php echo $registro['id_detalle_venta']; ?>)" role="button">Eliminar</a>
                    </td>
                </tr>
                <?php }?>
            </tbody>
        </table>
    </section>
</section>
<?php include("../templates/footer.php") ?>