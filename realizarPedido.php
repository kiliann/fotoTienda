<?php
require_once "metodos.php";
$metodos = new Metodos();
session_start();


?>
<!DOCTYPE html>
<html lang="es" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foto Tienda</title>
    <link type="text/css" rel="stylesheet" href="css/estilo.css">

</head>
<body>
<header>
    <h1>Foto Tienda</h1>
</header>
<nav>
    <a href="home.php">Inicio</a>
    <a href="realizarPedido.php"> Realizar Pedido</a>
    <a href="cerrarSesion.php">Cerrar Sesion</a>

</nav>




<div class="contenido">
    <div>
        <h1>Subir Imagenes</h1><br/>
        <form method="post" enctype="multipart/form-data" action="#">
            <label>Subier Imagenes</label>
            <!-- <input name="nombre" type="text" placeholder="Nombre de la Imagen" required><br/>-->
            <input type="file" name="imagenes"><br/>
            <input type="submit" id="submit" value="Subir">
        </form>


        <?php

        $metodos->subidaControladaImagenes();
        ?>
    </div>
</div>