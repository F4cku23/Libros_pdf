<?php 
    session_start();
    if(!isset($_SESSION['usuario'])){
        header("Location:../index.php");
    }else{
        if($_SESSION['usuario']=="ok"){
            $nombreUss=$_SESSION['nombreUsuario'];
        }else{
            $mensaje="usuario o contraseña incorrectos";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/darkly/bootstrap.min.css">
</head>
<body>
    <?php $url="http://".$_SERVER['HTTP_HOST']."/Libros_pdf" ?>
    <nav class="navbar navbar-expand navbar-light bg-light">
        <div class="nav navbar-nav">
            <a class="nav-item nav-link active" href="#">admin</a>
            <a class="nav-item nav-link" href="<?php echo $url; ?>/administrador/inicio.php">Inicio</a>
            <a class="nav-item nav-link" href="<?php echo $url; ?>/administrador/seccion/biblioteca.php">Libros</a>
            <a class="nav-item nav-link" href="<?php echo $url; ?>">Ir a web</a>
            <a class="nav-item nav-link" href="<?php echo $url; ?>/administrador/salir.php">Salir</a>
        </div>
    </nav>
    <div class="container">
        <div class="row">

