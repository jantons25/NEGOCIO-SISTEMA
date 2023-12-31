<?php include("../bd.php");

    $pag_actual =  "Ventas";

    $sentencia = $conexion->prepare("SELECT * FROM `tbl_producto`");
    $sentencia->execute();
    $lista_tbl_productos=$sentencia->fetchAll(PDO::FETCH_ASSOC);

    $sentencia_usuario = $conexion->prepare("SELECT * FROM `tbl_usuarios`");
    $sentencia_usuario->execute();
    $lista_tbl_usuarios=$sentencia_usuario->fetchAll(PDO::FETCH_ASSOC);

    if($_POST){ 
        $nombre_usuario=(isset($_POST["usuario"])?$_POST["usuario"]:"");
        
        foreach($lista_tbl_usuarios as $registro){
            if($registro["nombre_usuario"]==$nombre_usuario){
                $id_usuario = $registro["id_usuario"];
            }
        }

        $fecha_actual = date("Y-m-d");
        $estado = "Pagado";

        $dni=(isset($_POST["dni"])?$_POST["dni"]:"");
        $nombres=(isset($_POST["nombre"])?$_POST["nombre"]:"");
        $apellidos=(isset($_POST["apellidos"])?$_POST["apellidos"]:"");
        $telefono=(isset($_POST["telefono"])?$_POST["telefono"]:"");

        //DETALLE_VENTA
        $producto=(isset($_POST["producto"])?$_POST["producto"]:"");
        $cantidad=(isset($_POST["cantidad"])?$_POST["cantidad"]:"");
        $precio=(isset($_POST["precio"])?$_POST["precio"]:"");
        $descuento=(isset($_POST["descuento"])?$_POST["descuento"]:"");

        foreach($lista_tbl_productos as $registro){
            if($registro["id_producto"]==$producto){
                $id_producto = $registro["id_producto"];
            }
        }

        $sentencia_cliente=$conexion->prepare("INSERT INTO `tbl_cliente` (`id_cliente`, `nombres`, `apellidos`, `num_documento`, `telefono`) 
            VALUES (NULL,:nombres,:apellidos,:dni,:telefono);");
        $sentencia_cliente->bindParam(":nombres",$nombres);
        $sentencia_cliente->bindParam(":apellidos",$apellidos);   
        $sentencia_cliente->bindParam(":dni",$dni);   
        $sentencia_cliente->bindParam(":telefono",$telefono); 

        $sentencia_detalle=$conexion->prepare("INSERT INTO `tbl_detalle_venta` (`id_detalle_venta`, `id_producto`, `cantidad`, `precio`, `descuento`) 
            VALUES (NULL,:id_producto,:cantidad,:precio,:descuento);");

        $sentencia_detalle->bindParam(":id_producto",$id_producto);
        $sentencia_detalle->bindParam(":cantidad",$cantidad);   
        $sentencia_detalle->bindParam(":precio",$precio);   
        $sentencia_detalle->bindParam(":descuento",$descuento); 

        $sentencia_detalle->execute();
        $id_detalle_venta = $conexion->lastInsertId();
        $sentencia_cliente->execute();
        $id_cliente = $conexion->lastInsertId();

        $sentencia_venta=$conexion->prepare("INSERT INTO `tbl_venta` (`id_venta`, `id_detalle_venta`, `id_cliente`, `id_usuario`, `num_comprobante`,`fecha`,`total`,`estado` ) 
            VALUES (NULL,:id_detalle_venta, :id_cliente, :id_usuario, :num_comprobante, :fecha, :total, :estado);");

        $sentencia_venta->bindParam(":id_detalle_venta",$id_detalle_venta);
        $sentencia_venta->bindParam(":id_cliente",$id_cliente);   
        $sentencia_venta->bindParam(":id_usuario",$id_usuario);   
        $sentencia_venta->bindParam(":num_comprobante",$dni);
        $sentencia_venta->bindParam(":fecha",$fecha_actual); 
        $total = floatval($cantidad) * floatval($precio);
        $sentencia_venta->bindParam(":total",$total); 
        $sentencia_venta->bindParam(":estado", $estado);
        $sentencia_venta->execute();

        $mensaje = "Registro Agregado";
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
                <label for="dni" class="form-label">DNI</label>
                <input type="text" name="dni" class="form-control" id="dni" placeholder="Número de DNI">
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Nombre del cliente">
            </div>
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" name="apellidos" class="form-control" id="apellidos" placeholder="Apellidos">
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-control" id="telefono" placeholder="Número de teléfono">
            </div>
        </div>
    </section>
    <section class="form__crear form__crear__producto">
        <div class="form__crear__title">
            <h1 class="form__crear__h1">Datos de la Venta</h1>
        </div>
        <div class="form">
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" name="usuario" readonly class="form-control" id="usuario" placeholder="<?php echo $_SESSION['usuario']?>" value="<?php echo $_SESSION['usuario']?>">
            </div>
            <div class="mb-3">
                <label for="producto" class="form-label">Producto</label>
                <select class="form-select" aria-label="Default select example" name="producto" id="producto">
                    <?php foreach($lista_tbl_productos as $registro){ ?>
                        <option value=" <?php echo $registro['id_producto']; ?> "> <?php echo $registro['nombre'];?> </option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad</label>
                <input type="text" name="cantidad" class="form-control" id="cantidad" placeholder="Cantidad">
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="text" name="precio" class="form-control" id="precio" placeholder="Precio">
            </div>
            <div class="mb-3">
                <label for="descuento" class="form-label">Descuento</label>
                <input type="text" name="descuento" class="form-control" id="descuento" placeholder="Descuento">
            </div>
        </div>
    </section>
    <div class="col-12" id="col-12">
        <button type="submit" class="btn btn-success">Enviar</button>
        <a name="btncancelar" id="btncancelar" class="btn btn-danger" href="index.php" role="button">Cancelar</a>
    </div>
</form>
<?php include("../templates/footer.php"); ?>