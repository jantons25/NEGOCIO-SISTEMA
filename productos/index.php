<?php include("../bd.php"); 

    $pag_actual =  "Productos";

    $sentencia = $conexion->prepare("SELECT *,
    (SELECT nombre FROM tbl_categoria WHERE tbl_categoria.id_categoria = tbl_producto.id_categoria limit 1) as nombre_categoria
    FROM `tbl_producto`");
    $sentencia->execute();
    $lista_tbl_productos=$sentencia->fetchAll(PDO::FETCH_ASSOC);

    if(isset($_GET['txtID'])){ 
        $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";

        $sentencia = $conexion->prepare("SELECT imagen FROM `tbl_producto` WHERE id_producto=:id_producto");
        $sentencia->bindParam(":id_producto",$txtID);  
        $sentencia->execute();

        $registro_recuperado=$sentencia->fetch(PDO::FETCH_LAZY);

        if(isset($registro_recuperado["imagen"]) && $registro_recuperado["imagen"]!=""){
            if(file_exists("./".$registro_recuperado["imagen"])){
                unlink("./".$registro_recuperado["imagen"]);
            }
        }

        $sentencia=$conexion->prepare("DELETE FROM tbl_producto WHERE id_producto=:id_producto");
        $sentencia->bindParam(":id_producto",$txtID);   
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
        <a name="" id="" class="btn btn-primary" href="crear.php" role="button">Agregar Producto</a> 
    </article>
    <section class="venta__table">
        <table class="table table-striped" id="tabla_id">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Codigo</th>
                    <th scope="col">Precio/Unidad</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Imagen</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($lista_tbl_productos as $registro){?>
                <tr>
                    <th scope="row"><?php echo $registro['id_producto'];?></th>
                    <td><?php echo $registro['nombre_categoria'];?></td>
                    <td><?php echo $registro['nombre'];?></td>
                    <td><?php echo $registro['codigo'];?></td>
                    <td>S/<?php echo $registro['precio_venta']?>.00</td>
                    <td><?php echo $registro['stock'];?></td>
                    <td>
                        <img src="<?php echo $url_base."/productos/".$registro['imagen'];?>" alt="" class="img__producto">
                    </td>
                    <td><?php echo $registro['estado']?></td>
                    <td>
                        <a name="btneditar"  id="btnborrar" class="btn btn-info" href="editar.php?txtID=<?php echo $registro['id_producto']; ?>" role="button">Editar</a>
                        <a name="btnborrar"  id="btnborrar" class="btn btn-danger" href="javascript:borrar(<?php echo $registro['id_producto']; ?>)" role="button">Eliminar</a>
                    </td>
                </tr>
                <?php }?>
            </tbody>
        </table>
    </section>
</section>
<?php include("../templates/footer.php") ?>