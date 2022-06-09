<?php include('../template/cabecera.php') ?>


<?php
    $txtID=(isset($_POST['txtID']))?$_POST['txtID']:'';
    $txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:'';
    $img=(isset($_FILES['img']['name']))?$_FILES['img']['name']:'';
    $accion=(isset($_POST['accion']))?$_POST['accion']:'';

include('../config/db.php');

    switch($accion){
        case "Agregar";
            //INSERT INTO `libros`(`id`, `nombre`, `imagen`) VALUES ('ID','NOMBRE','IMG')
            $sentenciaSQL=$conexion->prepare("INSERT INTO libros(nombre, imagen) VALUES (:nombre,:imagen);");
            $sentenciaSQL->bindParam(':nombre',$txtNombre);
            $fecha=new DateTime();
            $nombreImg=($img!="")?$fecha->getTimestamp()."_".$_FILES['img']['name']:"imagen.jpg";

            $tmpImg=$_FILES['img']['tmp_name'];
            if($tmpImg!=""){
                move_uploaded_file($tmpImg, "../../img/".$nombreImg);
            }

            $sentenciaSQL->bindParam(':imagen',$nombreImg);
            $sentenciaSQL->execute();
            header("Location:biblioteca.php");
            break;
        case "Modificar";
            $sentenciaSQL=$conexion->prepare("UPDATE libros SET nombre=:nombre WHERE id=:id");
            $sentenciaSQL->bindParam(':nombre',$txtNombre);
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();

            //verifica datos de img a modificar
            if($img!=""){
                $fecha=new DateTime();
                $nombreImg=($img!="")?$fecha->getTimestamp()."_".$_FILES['img']['name']:"imagen.jpg";

                $tmpImg=$_FILES['img']['tmp_name'];
                move_uploaded_file($tmpImg, "../../img/".$nombreImg);

                $sentenciaSQL=$conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
                $sentenciaSQL->bindParam(':id',$txtID);
                $sentenciaSQL->execute();
                $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

                if(isset($libro['imagen']) && ($libro['imagen']!="imagen.jpg")){
                    if(file_exists("../../img/".$libro['imagen'])){
                        unlink("../../img/".$libro['imagen']);
                    }
                }

                //una vez localizada img antigua y eliminada se sube la img 
                $sentenciaSQL=$conexion->prepare("UPDATE libros SET imagen=:imagen WHERE id=:id");
                $sentenciaSQL->bindParam(':imagen',$nombreImg);
                $sentenciaSQL->bindParam(':id',$txtID);
                $sentenciaSQL->execute();
            }
            header("Location:biblioteca.php");
            break;
        case "Cancelar";
            header("Location:biblioteca.php");
            break;
        case "Seleccionar";
            $sentenciaSQL=$conexion->prepare("SELECT * FROM libros WHERE id=:id");
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();
            $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
            $txtNombre=$libro['nombre'];
            $img=$libro['imagen'];
            break;
        case "Borrar";
            $sentenciaSQL=$conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();
            $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

            if(isset($libro['imagen']) && ($libro['imagen']!="imagen.jpg")){
                if(file_exists("../../img/".$libro['imagen'])){
                    unlink("../../img/".$libro['imagen']);
                }
            }

            $sentenciaSQL=$conexion->prepare("DELETE FROM libros WHERE id=:id");
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();
            header("Location:biblioteca.php");
            break;
    }

    $sentenciaSQL=$conexion->prepare("SELECT * FROM libros");
    $sentenciaSQL->execute();
    $listarLibros=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>


    <div class="col-md-4"><br>
        <div class="card">
            <div class="card-header">
                Datos libro PDF
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="txtID">ID:</label>
                        <input type="text" class="form-control" name="txtID" id="txtID" value="<?php echo $txtID; ?>" require readonly>
                    </div>
                    <div class="form-group">
                        <label for="txtNombre">Nombre:</label>
                        <input type="text" class="form-control" name="txtNombre" id="txtNombre" value="<?php echo $txtNombre; ?>" require>
                    </div>
                    <div class="form-group">
                        <label for="txtID">Imagen:</label>

                        <?php if($img!=""){ ?>
                            <img src="../../img/<?php echo $img; ?>" width="50" alt="imgLibro">
                        <?php } ?>

                        <input type="file" class="form-control" name="img" id="txtID" require>
                    </div><br>
                    <div class="btn-group" role="group" aria-label="">
                        <button type="submit"name="accion" value="Agregar" <?php echo ($accion=="Seleccionar")?"disabled":"" ?> class="btn btn-success">Agregar</button>
                        <button type="submit"name="accion" value="Modificar" <?php echo ($accion!="Seleccionar")?"disabled":"" ?> class="btn btn-warning">Modificar</button>
                        <button type="submit"name="accion" value="Cancelar" <?php echo ($accion!="Seleccionar")?"disabled":"" ?> class="btn btn-info">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
    
    <div class="col-md-8">
        <br>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($listarLibros as $libro){ ?>
                <tr>
                    <td><?php echo $libro['id'] ?></td>
                    <td><?php echo $libro['nombre'] ?></td>
                    <td>
                        <img src="../../img/<?php echo $libro['imagen'] ?>" width="50" alt="imgLibro">
                    </td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="txtID" id="txtID" value="<?php echo $libro['id']; ?>" />
                            <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary"/>
                            <input type="submit" name="accion" value="Borrar" class="btn btn-danger"/>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

    </div>

<?php include('../template/pie.php') ?>