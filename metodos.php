<?php


class Metodos
{
    public function __construct()
    {
        require_once 'Conexion.php';
        $this->conexion = new Conexion();

    }

    //Aqui realizamos el alta de usuario
    function altaUsuario($nombre, $correo, $password, $rpassword, $telefono)
    {
        if ($password == $rpassword) {

            $password_encry = password_hash($password, PASSWORD_BCRYPT);
            $insercion = "INSERT INTO clientes(correo, nombre, password, telefono) VALUES ('$correo','$nombre','$password_encry', $telefono)";
            $consulta = "SELECT correo FROM clientes WHERE correo LIKE '$correo'";
            $comprobacion = $this->conexion->consultas($consulta);
            //echo $comprobacion = $this->conexion->filasAfectadas()  ;
            //Primero comprobamos si el usuario no existe ya en la base de datos

            if ($this->conexion->numeroFilas($comprobacion) > 0) {
                echo "Este correo esta ya registrado";
            } else {
                //Aqui realizamos el alta del usuario  y si falla el alta devolvemos el numero de error
                if ($this->conexion->consultas($insercion)) {
                    echo "Se realizo conrrectamente el registro";
                } else {
                    $this->conexion->errno();
                }
            }
        } else {
            echo "La contraseña no es correcta";
        }


    }
    //Incio de sesion con consultas preprarada y contraseñas encriptadas
    public function iniciarSesion($correo, $password)
    {
        //Creamos al consulta
        $consulta = "SELECT * FROM clientes WHERE correo = ?";

        //Preparamos con preparae
        if (!$sentencia = $this->conexion->mysqli->prepare($consulta)) {
            echo "La consulta fallo en su preparacion";
        }
        //Pasamos los parametros y el tipo de dato
        if (!$sentencia->bind_param("s", $correo)) {
            echo "Fallo en la vinculacion de parametros";
        }
        //Ejecutamos con execute
        if (!$sentencia->execute()) {
            echo "Algo fallo en la ejecucion";

        }
        // Vemos lo que nos devuelve con get_result
        $resultado = $sentencia->get_result();
        if ($this->conexion->numeroFilas($resultado) > 0) {
            while ($fila = $resultado->fetch_array(MYSQLI_ASSOC)) {
                //echo $fila['correo'];
                //echo $fila['password'];
                //Si es correcto la contraseña Inicia la sesion y manda a la pagina home o incio.
                if (password_verify($password, $fila['password'])) {
                    session_start();
                    $_SESSION['usuario'] = $fila['correo'];
                    header("Location: home.php");
                } else {
                    echo "La contraseña es incorrectos";
                }
            }
        } else {
            echo "El correo introducido no es correcto";
        }

    }

//Subimos las imagenes y pasamos el parametro Carpeta Destino que es donde se guardadn las imagenes del pedido,
    function subidaControladaImagenes($carpetaDestino)
    {
        if (isset($_FILES['imagenes'])) {


           foreach ($_FILES["imagenes"]['tmp_name'] as $key => $tmp_name) {
               //Si el archivo contiene algo y es diferente de vacio
               if ($_FILES['imagenes']['name'][$key]) {
                   $archivo = $_FILES['imagenes']['name'][$key];
                   //Obtenemos algunos datos necesarios sobre el archivo
                   $tipo = $_FILES['imagenes']['type'][$key];
                   $tamano = $_FILES['imagenes']['size'][$key];
                   $temp = $_FILES['imagenes']['tmp_name'][$key];
                   //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
                   if (!((strpos($tipo, "gif") || strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png")) && ($tamano < 2000000))) {
                       echo '<div><b>Error. La extensión o el tamaño de los archivos no es correcta.<br/>
        - Se permiten archivos .gif, .jpg, .png. y de 200 kb como máximo.</b></div>';
                   } else {
                       //Abrimos la carpeta
                       $dir=opendir($carpetaDestino);
                       //Si la imagen es correcta en tamaño y tipo
                       //Se intenta subir al servidor
                       if (move_uploaded_file($temp, $carpetaDestino."/" .$archivo)) {
                           //Cambiamos los permisos del archivo a 777 para poder modificarlo posteriormente
                           //chmod('images/'.$archivo, 0777);
                           //Mostramos el mensaje de que se ha subido co éxito
                           echo '<p>Se ha subido correctamente la imagen.</p>';
                           //Mostramos la imagen subida
                            echo '<div id="imagenesSubidas" style="width: 500px;"><img src="'.$carpetaDestino.'/' . $archivo . '"></div>';
                       } else {
                           //Si no se ha podido subir la imagen, mostramos un mensaje de error
                           echo '<div><b>Ocurrió algún error al subir el fichero. No pudo guardarse.</b></div>';
                       }
                       //cerrramos el fichero
                       closedir($dir);
                   }
               }
           }
           echo"<a class='subir' href='home.php'>Terminar Pedido</a>";
        }
    }
    // Con este metodo generamos la carpeta del pedido
    function crearCarpetaPedido()
    {
        //samamos +1 al ultimo pedido para generar la nueva carpeta que es el id
        $estructura = $this->ultimoPedido() + 1;
        //lo hacemos con mkdir y le damos permisos
        if (!mkdir($estructura, 0777, true)) {
            echo "Fallo al crear la carpeta";
        } else {
            //creamos el pedido una vez generada la carpeta
            $this->crearPedido();
        }
        return $estructura;
    }
    //Aqui devolvemos el ultimo pedido realizado
    function ultimoPedido()
    {

        $consulta = "SELECT MAX(idPedido) as idPedido FROM pedidos WHERE 1";

        $resultado = $this->conexion->consultas($consulta);

        while ($fila = $this->conexion->extraerFila($resultado)) {
            //echo $fila['idPedido'] ;
            if ($fila['idPedido'] != 0) {
                return $fila['idPedido'];
            } else {
                return 0;
            }

        }


    }
    //Generamos el pedido con esta funcion
    function crearPedido(){
        //Cogemos el usuario de la sesion para crear el pedido con su idCliente
        $cliente = $_SESSION['usuario'];
        $buscarCliente = "SELECT idCliente FROM clientes WHERE correo LIKE '$cliente' ";
        if ($resultado = $this->conexion->consultas($buscarCliente)) {
            while ($fila = $this->conexion->extraerFila($resultado))
                $idcliente = $fila['idCliente'];
            $insertarPedido = "INSERT INTO pedidos( idCliente) VALUES ($idcliente)";
            if (!$this->conexion->consultas($insertarPedido)) {
                echo "Un error al crear el pedido";
            }
        }
    }




}