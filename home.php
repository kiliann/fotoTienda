<?php
session_start();
$_SESSION['usuario'];


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


</body>
</html>
