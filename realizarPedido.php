<?php
require_once "metodos.php";
$metodos = new Metodos();
session_start();

//Aqui contrlamos el acceso a los usurio para que no pueda acceder nadie sin registrar
if(isset($_SESSION['usuario'])){



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

            <input type="file" name="imagenes[]" multiple=""><br/>
            <h3>Selección Multiple Pulse "ctrl" y selecciones las Imganes<br/>
            Tamaño maximo archivo 2 MB</h3><br/>
            <input class="subir" type="submit" id="submit" value="Subir">
        </form>

        <?php
        //Aqui es donde cada vez qu ele damos a subir se genera el pedido completo y muetra las imagenes subidas
        // como mejoras lo ideal seria generar la carpeta y hasta no terminar el pedido que no se pudiera generar
        // Eso es una mejora para añadir que no se realizo por falta de tiempo.
        if (isset($_FILES['imagenes'])){
            echo "<div id='imagenesSubidas'>";
            $metodos->subidaControladaImagenes($metodos->crearCarpetaPedido());
            echo "</div>";
        }

        ?>


    </div>

</div>



<?php
}else{
    echo "Acceso denegado";
}
?>