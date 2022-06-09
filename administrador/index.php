<?php
session_start();
    if($_POST){
        if(($_POST['usuario']=="admin") && ($_POST['password']=="admin")){
            $_SESSION['usuario']="";
            $_SESSION['nombreUsuario']="admin";
            header('Location:inicio.php'); 
        }
    }
?>
<?php include "template/cabecera.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
<br>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <legend>Login</legend>
                    </div>
                    <div class="card-body">
                    <?php if(isset($mensaje)){ ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $mensaje?>
                            </div>
                        <?php } ?>
                        <form method="POST">
                            <fieldset>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="usuario" placeholder="Usuario">
                                </div><br>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="password" placeholder="Password">
                                </div><br>
                                <button type="submit" class="btn btn-primary">Ingresar</button>
                            </fieldset>
                        </form>

                    </div>
                </div>
            </div>
            
        </div>
    </div>

</body>
</html>