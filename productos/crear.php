<?php include("../bd.php");

    $pag_actual =  "Productos";

    $sentencia = $conexion->prepare("SELECT * FROM `tbl_producto`");
    $sentencia->execute();
    $lista_tbl_productos=$sentencia->fetchAll(PDO::FETCH_ASSOC);

    $sentencia_categoria = $conexion->prepare("SELECT * FROM `tbl_categoria`");
    $sentencia_categoria->execute();
    $lista_tbl_categoria=$sentencia_categoria->fetchAll(PDO::FETCH_ASSOC);

    if($_POST){ 

        $nombre=(isset($_POST["nombre"])?$_POST["nombre"]:"");
        $codigo=(isset($_POST["codigo"])?$_POST["codigo"]:"");
        $precioventa=(isset($_POST["precioventa"])?$_POST["precioventa"]:"");
        $stock=(isset($_POST["stock"])?$_POST["stock"]:"");
        $categoria=(isset($_POST["categoria"])?$_POST["categoria"]:"");
        $estado=(isset($_POST["estado"])?$_POST["estado"]:"");
        $foto=(isset($_FILES["foto"]['name'])?$_FILES["foto"]['name']:"");

        foreach($lista_tbl_categoria as $registro){
            if($registro["id_categoria"]==$categoria){
                $id_categoria = $registro["id_categoria"];
            }
        }

        $sentencia_producto=$conexion->prepare("INSERT INTO `tbl_producto` (`id_producto`, `id_categoria`, `nombre`, `codigo`, `precio_venta`,  `stock`, `imagen`, `estado`) 
            VALUES (NULL,:id_categoria,:nombre,:codigo,:precio_venta,:stock,:imagen,:estado);");
        $sentencia_producto->bindParam(":id_categoria",$id_categoria);
        $sentencia_producto->bindParam(":nombre",$nombre);
        $sentencia_producto->bindParam(":codigo",$codigo);
        $sentencia_producto->bindParam(":precio_venta",$precioventa);
        $sentencia_producto->bindParam(":stock",$stock);
        $sentencia_producto->bindParam(":estado",$estado);

        $fecha=new DateTime(); 
        $nombreArchivo_foto=($foto!='')?$fecha->getTimestamp()."_".$_FILES["foto"]['name']:"";
        $tmp_foto=$_FILES["foto"]['tmp_name'];
        if($tmp_foto!=''){
            move_uploaded_file($tmp_foto,"./".$nombreArchivo_foto);
        }

        $sentencia_producto->bindParam(":imagen",$nombreArchivo_foto); 
        $sentencia_producto->execute();
        
        $mensaje = "Registro Agregado";
        header("Location:index.php?mensaje=".$mensaje);
    }

?>


<?php include("../templates/header.php"); ?>
<?php $url_base="http://localhost/NEGOCIO-SISTEMA"; ?>

<head>
    <link rel="stylesheet" href="<?php echo $url_base?>/Style/PRODUCTOS/style.css">
</head>
<section class="form__crear form__crear__producto">
    <div class="form__crear__title">
        <h1 class="form__crear__h1">Datos del producto</h1>
    </div>
    <form action="" method="post" enctype="multipart/form-data" class="form">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Nombre del producto">
        </div>
        <div class="mb-3">
            <label for="codigo" class="form-label">Código</label>
            <input type="text" name="codigo" class="form-control" id="codigo" placeholder="Código del producto">
        </div>
        <div class="mb-3">
            <label for="precioventa" class="form-label">Precio de venta</label>
            <input type="text" name="precioventa" class="form-control" id="precioventa" placeholder="Precio de venta">
        </div>
        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="text" name="stock" class="form-control" id="stock" placeholder="Stock">
        </div>
        <div class="mb-3">
            <label for="foto" class="form-label">Foto</label>
            <input type="file" class="form-control" name="foto" id="foto" placeholder=""/>
        </div>
        <div class="mb-3">
            <label for="categoria" class="form-label">Categoria</label>
            <select class="form-select" aria-label="Default select example" name="categoria" id="categoria">
                <?php foreach($lista_tbl_categoria as $registro){ ?>
                    <option value=" <?php echo $registro['id_categoria']; ?> "> <?php echo $registro['nombre'];?> </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="estaso" class="form-label">Estado</label>
            <select class="form-select" aria-label="Default select example" name="estado" id="estado">
                <option selected value="Activo">Activo</option>
                <option value="Desactivado">Desactivado</option>
            </select>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn__form">Enviar</button>
            <a name="btncancelar" id="btncancelar" class="btn btn-danger" href="index.php" role="button">Cancelar</a>
        </div>
    </form>
</section>
<?php include("../templates/footer.php") ?>