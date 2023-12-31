<?php
    include("../bd.php");

    $pag_actual =  "Productos";

    if(isset($_GET['txtID'])){ 
        $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";

        $sentencia=$conexion->prepare("SELECT *,
        (SELECT nombre FROM tbl_categoria WHERE tbl_categoria.id_categoria = tbl_producto.id_categoria limit 1) as nombre_categoria
        FROM tbl_producto WHERE id_producto=:id_producto");
        $sentencia->bindParam(":id_producto",$txtID);   
        $sentencia->execute();

        $registro=$sentencia->fetch(PDO::FETCH_LAZY);
        $id_producto=$registro["id_producto"];
        $id_categoria=$registro["id_categoria"];
        $nomre_categoria=$registro["nombre_categoria"];
        $nombre=$registro["nombre"];
        $codigo=$registro["codigo"];
        $precio_venta=$registro["precio_venta"];
        $stock=$registro["stock"];
        $imagen=$registro["imagen"];
        $estado=$registro["estado"];

        $estado_actual="";
        if($estado == 'Activo'){
            $estado_actual = "Desactivado";
        }elseif($estado == 'Desactivado'){
            $estado_actual = "Activo";
        }

        $sentencia = $conexion->prepare("SELECT * FROM `tbl_categoria`");
        $sentencia->execute();
        $lista_tbl_categorias=$sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    if($_POST){
        $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";

        $id_categoria=(isset($_POST["categoria"])?$_POST["categoria"]:"");
        $nombre=(isset($_POST["nombre"])?$_POST["nombre"]:"");
        $codigo=(isset($_POST["codigo"])?$_POST["codigo"]:"");
        $precio_venta=(isset($_POST["precioventa"])?$_POST["precioventa"]:"");
        $stock=(isset($_POST["stock"])?$_POST["stock"]:"");
        $estado=(isset($_POST["estado"])?$_POST["estado"]:"");

        $sentencia=$conexion->prepare("UPDATE `tbl_producto` SET
        id_categoria=:id_categoria,
        nombre=:nombre,
        codigo=:codigo,
        precio_venta=:precio_venta,
        stock=:stock,
        estado=:estado
        WHERE id_producto=:id_producto ");

        $sentencia->bindParam(":id_categoria",$id_categoria);
        $sentencia->bindParam(":nombre",$nombre);   
        $sentencia->bindParam(":codigo",$codigo);   
        $sentencia->bindParam(":precio_venta",$precio_venta); 
        $sentencia->bindParam(":stock",$stock);
        $sentencia->bindParam(":estado",$estado);  
        $sentencia->bindParam(":id_producto",$txtID); 
        $sentencia->execute();

        $foto=(isset($_FILES["foto"]['name'])?$_FILES["foto"]['name']:"");
        $fecha=new DateTime(); 
        $nombreArchivo_foto=($foto!='')?$fecha->getTimestamp()."_".$_FILES["foto"]['name']:"";
        $tmp_foto=$_FILES["foto"]['tmp_name'];
        if($tmp_foto!=''){
            move_uploaded_file($tmp_foto,"./".$nombreArchivo_foto);

            $sentencia = $conexion->prepare("SELECT imagen FROM `tbl_producto` WHERE id_producto=:id_producto");
            $sentencia->bindParam(":id_producto",$txtID);  
            $sentencia->execute();
            $registro_recuperado=$sentencia->fetch(PDO::FETCH_LAZY);

            if(isset($registro_recuperado["imagen"]) && $registro_recuperado["imagen"]!=""){
                if(file_exists("./".$registro_recuperado["imagen"])){
                    unlink("./".$registro_recuperado["imagen"]);
                }
            }

            $sentencia=$conexion->prepare("UPDATE `tbl_producto` SET imagen=:imagen WHERE id_producto=:id_producto ");
            $sentencia->bindParam(":imagen",$nombreArchivo_foto); 
            $sentencia->bindParam(":id_producto",$txtID);
            $sentencia->execute();
        }    
        $mensaje = "Registro Actualizado";
        header("Location:index.php?mensaje=".$mensaje);
    }
?>
<?php include("../templates/header.php") ?>
<?php $url_base="http://localhost/NEGOCIO-SISTEMA"; ?>
<head>
    <link rel="stylesheet" href="<?php echo $url_base?>/Style/PRODUCTOS/style.css">
    <link rel="stylesheet" href="<?php echo $url_base?>/Style/PRODUCTOS/editar.css">
</head>
<section class="form__crear form__crear__producto">
    <div class="form__crear__title">
        <h1 class="form__crear__h1">Actualizar datos del producto</h1>
    </div>
    <div class="formulario">
        <figure class="form__figure">
            <img src="<?php echo $url_base;?>/productos/<?php echo $imagen;?>" alt="" class="form__img">
        </figure>
        <form action="" id="form" method="post" enctype="multipart/form-data" class="form">
            <div class="mb-3">
                <label for="txtID" class="form-label">ID</label>
                <input type="text" name="txtID" readonly class="form-control" id="txtID" value="<?php echo $txtID;?>">
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" id="nombre" value="<?php echo $nombre;?>">
            </div>
            <div class="mb-3">
                <label for="codigo" class="form-label">Código</label>
                <input type="text" name="codigo" class="form-control" id="codigo" value="<?php echo $codigo;?>">
            </div>
            <div class="mb-3">
                <label for="precioventa" class="form-label">Precio de venta</label>
                <input type="text" name="precioventa" class="form-control" id="precioventa" value="S/<?php echo $precio_venta;?>.00">
            </div>
            <div class="mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="text" name="stock" class="form-control" id="stock" value="<?php echo $stock;?>">
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto: <?php echo $imagen;?></label>
                <input type="file" class="form-control" name="foto" id="foto" placeholder="" value="<?php echo $imagen?>"/>
            </div>
            <div class="mb-3">
                <label for="categoria" class="form-label">Categoria</label>
                <select class="form-select" aria-label="Default select example" name="categoria" id="categoria">
                    <?php foreach($lista_tbl_categorias as $registro){?>
                        <option <?php echo ($id_categoria == $registro['id_categoria'])?"selected":"";  ?> value=" <?php echo $registro['id_categoria'] ?> "> <?php echo $registro['nombre']?></option>
                    <?php }?>
                </select>
            </div>
            <div class="mb-3">
                <label for="estaso" class="form-label">Estado</label>
                <select class="form-select" aria-label="Default select example" name="estado" id="estado">
                    <option selected value="<?php echo $estado;?>"><?php echo $estado;?></option>
                    <option value="<?php echo $estado_actual;?>"><?php echo $estado_actual;?></option>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn__form">Enviar</button>
                <a name="btncancelar" id="btncancelar" class="btn btn-danger" href="index.php" role="button">Cancelar</a>
            </div>
        </form>
    </div>
</section>
<?php include("../templates/footer.php") ?>