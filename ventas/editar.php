<?php
    include("../bd.php");

    $pag_actual =  "Ventas";

    $sentencia_recuperar_venta = $conexion->prepare("SELECT * FROM `tbl_venta`");
    $sentencia_recuperar_venta->execute();
    $lista_tbl_venta=$sentencia_recuperar_venta->fetchAll(PDO::FETCH_ASSOC);

    if(isset($_GET['txtID'])){ 
        $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";

        $sentencia=$conexion->prepare("SELECT *,
        (SELECT nombre FROM tbl_producto WHERE tbl_producto.id_producto = tbl_detalle_venta.id_producto limit 1) as nombre_producto
        FROM tbl_detalle_venta WHERE id_detalle_venta=:id_detalle_venta");
        $sentencia->bindParam(":id_detalle_venta",$txtID);   
        $sentencia->execute();

        $registro=$sentencia->fetch(PDO::FETCH_LAZY);
        $id_detalle_venta = $registro["id_detalle_venta"];
        $id_producto = $registro["id_producto"];
        $nombre_producto = $registro["nombre_producto"];
        $cantidad = $registro["cantidad"];
        $precio = $registro["precio"];
        $descuento = $registro["descuento"];

        $sentencia = $conexion->prepare("SELECT * FROM `tbl_producto`");
        $sentencia->execute();
        $lista_tbl_productos=$sentencia->fetchAll(PDO::FETCH_ASSOC);

        $sentencia_cliente = $conexion->prepare("SELECT * FROM `tbl_cliente`");
        $sentencia_cliente->execute();
        $lista_tbl_clientes=$sentencia_cliente->fetchAll(PDO::FETCH_ASSOC);

        $sentencia_venta = $conexion->prepare("SELECT * FROM `tbl_venta`");
        $sentencia_venta->execute();
        $lista_tbl_ventas=$sentencia_venta->fetchAll(PDO::FETCH_ASSOC);

        foreach($lista_tbl_ventas as $registro){
            if($registro["id_detalle_venta"]==$id_detalle_venta){
                $dato_cliente=$registro["id_cliente"];
                foreach($lista_tbl_clientes as $clientes){
                    if($clientes["id_cliente"]==$dato_cliente){
                        $dni = $clientes["num_documento"];
                        $nombre_cliente = $clientes["nombres"];
                        $apellidos = $clientes["apellidos"];
                        $telefono = $clientes["telefono"];
                        $id_cliente = $clientes["id_cliente"];
                    }
                }
            }
        }  
    }
    if($_POST){ 

        $id_cliente=(isset($_POST["id_cliente"])?$_POST["id_cliente"]:"");
        $nombres=(isset($_POST["nombres"])?$_POST["nombres"]:"");
        $apellidos=(isset($_POST["apellidos"])?$_POST["apellidos"]:"");
        $num_documento=(isset($_POST["dni"])?$_POST["dni"]:"");
        $telefono=(isset($_POST["telefono"])?$_POST["telefono"]:"");

        $id_detalle_venta=(isset($_POST["id_detalle_venta"])?$_POST["id_detalle_venta"]:"");
        $producto=(isset($_POST["producto"])?$_POST["producto"]:"");
        $cantidad=(isset($_POST["cantidad"])?$_POST["cantidad"]:"");
        $precio=(isset($_POST["precio"])?$_POST["precio"]:"");
        $descuento=(isset($_POST["descuento"])?$_POST["descuento"]:"");

        foreach($lista_tbl_productos as $registro){
            if($registro["id_producto"]==$producto){
                $id_producto = $registro["id_producto"];
            }
        }

        $sentencia_detalle=$conexion->prepare("UPDATE tbl_detalle_venta SET id_producto=:id_producto, cantidad=:cantidad, precio=:precio, descuento=:descuento
            WHERE id_detalle_venta=:id_detalle_venta");
        $sentencia_detalle->bindParam(":id_detalle_venta",$id_detalle_venta);
        $sentencia_detalle->bindParam(":id_producto",$id_producto);
        $sentencia_detalle->bindParam(":cantidad",$cantidad);   
        $sentencia_detalle->bindParam(":precio",$precio);
        $sentencia_detalle->bindParam(":descuento",$descuento);
        $sentencia_detalle->execute();

        $sentencia_cliente=$conexion->prepare("UPDATE tbl_cliente SET nombres=:nombres, apellidos=:apellidos, num_documento=:num_documento, telefono=:telefono
            WHERE id_cliente=:id_cliente");
        $sentencia_cliente->bindParam(":id_cliente",$id_cliente);
        $sentencia_cliente->bindParam(":nombres",$nombres);
        $sentencia_cliente->bindParam(":apellidos",$apellidos);   
        $sentencia_cliente->bindParam(":num_documento",$num_documento);
        $sentencia_cliente->bindParam(":telefono",$telefono);
        $sentencia_cliente->execute();

        foreach($lista_tbl_venta as $registro){
            if($registro["id_detalle_venta"]==$id_detalle_venta){
                $id_venta = $registro["id_venta"];
            }
        }

        $sentencia_venta=$conexion->prepare("UPDATE tbl_venta SET total=:total
            WHERE id_venta=:id_venta");
        $sentencia_venta->bindParam(":id_venta",$id_venta);
        $total = floatval($cantidad) * floatval($precio);
        $sentencia_venta->bindParam(":total",$total);
        $sentencia_venta->execute();

        $mensaje = "Registro Actualizado";
        header("Location:index.php?mensaje=".$mensaje);
    }
?>
<?php include("../templates/header.php"); ?>
<?php $url_base="http://localhost/NEGOCIO-SISTEMA"; ?>
<head>
    <link rel="stylesheet" href="<?php echo $url_base?>/Style/PRODUCTOS/style.css">
    <link rel="stylesheet" href="<?php echo $url_base?>/Style/VENTAS/crear.css">
</head>
<form id="article__crear__venta" action="" method="post" enctype="multipart/form-data">
    <section class="form__crear form__crear__producto">
        <div class="form__crear__title">
            <h1 class="form__crear__h1">Datos del cliente</h1>
        </div>
        <div class="form">
            <div class="mb-3">
                <label for="id_cliente" class="form-label">ID Cliente</label>
                <input type="text" name="id_cliente" class="form-control" id="id_cliente" value="<?php echo $id_cliente;?>">
            </div>
            <div class="mb-3">
                <label for="dni" class="form-label">DNI</label>
                <input type="text" name="dni" class="form-control" id="dni" value="<?php echo $dni;?>">
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombres" class="form-control" id="nombres" value="<?php echo $nombre_cliente;?>">
            </div>
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" name="apellidos" class="form-control" id="apellidos" value="<?php echo $apellidos;?>">
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-control" id="telefono" value="<?php echo $telefono;?>">
            </div>
        </div>
    </section>
    <section class="form__crear form__crear__producto">
        <div class="form__crear__title">
            <h1 class="form__crear__h1">Datos de la Venta</h1>
        </div>
        <div class="form">
            <div class="mb-3">
                <label for="cantidad" class="form-label">ID Detalle venta</label>
                <input type="text" name="id_detalle_venta" class="form-control" id="id_detalle_venta" value="<?php echo $id_detalle_venta;?>">
            </div>
            <div class="mb-3">
                <label for="producto" class="form-label">Producto</label>
                <select class="form-select" aria-label="Default select example" name="producto" id="producto">
                    <?php foreach($lista_tbl_productos as $registro){?>
                        <option <?php echo ($id_producto == $registro['id_producto'])?"selected":"";  ?> value=" <?php echo $registro['id_producto'] ?> "> <?php echo $registro['nombre']?></option>
                    <?php }?>
                </select>
            </div>
            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad</label>
                <input type="text" name="cantidad" class="form-control" id="cantidad" value="<?php echo $cantidad;?>">
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="text" name="precio" class="form-control" id="precio" value="<?php echo $precio;?>">
            </div>
            <div class="mb-3">
                <label for="descuento" class="form-label">Descuento</label>
                <input type="text" name="descuento" class="form-control" id="descuento" value="S/<?php echo $descuento;?>">
            </div>
        </div>
    </section>
    <div class="col-12" id="col-12">
        <button type="submit" class="btn btn__form">Guardar</button>
        <a name="btncancelar" id="btncancelar" class="" href="index.php" role="button">
            <button type="submit" class="btn btn-danger">Cancelar</button>
        </a>
    </div>
</form>
<?php include("../templates/footer.php"); ?>