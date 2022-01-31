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

    public function iniciarSesion($correo, $password)
    {

        $consulta = "SELECT * FROM clientes WHERE correo = ?";


        if (!$sentencia = $this->conexion->mysqli->prepare($consulta)) {
            echo "La consulta fallo en su preparacion";
        }

        if (!$sentencia->bind_param("s", $correo)) {
            echo "Fallo en la vinculacion de parametros";
        }

        if (!$sentencia->execute()) {
            echo "Algo fallo en la ejecucion";

        }

        $resultado = $sentencia->get_result();
        if($this->conexion->numeroFilas($resultado) > 0){
            while ($fila = $resultado->fetch_array(MYSQLI_ASSOC)) {
                //echo $fila['correo'];
                //echo $fila['password'];
                if (password_verify($password, $fila['password'])) {
                    session_start();
                    $_SESSION['usuario'] = $fila['correo'];
                    header("Location: home.php");
                }else{
                    echo "La contraseña es incorrectos";
                }
            }
        }else{
            echo "El correo introducido no es correcto";
        }

    }


    function subidaControladaImagenes()
    {
        if (isset($_FILES['imagenes'])) {
            $archivo = $_FILES['imagenes']['name'];
            //Si el archivo contiene algo y es diferente de vacio
            if (isset($archivo) && $archivo != "") {
                //Obtenemos algunos datos necesarios sobre el archivo
                $tipo = $_FILES['imagenes']['type'];
                $tamano = $_FILES['imagenes']['size'];
                $temp = $_FILES['imagenes']['tmp_name'];
                //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
                if (!((strpos($tipo, "gif") || strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png")) && ($tamano < 2000000))) {
                    echo '<div><b>Error. La extensión o el tamaño de los archivos no es correcta.<br/>
        - Se permiten archivos .gif, .jpg, .png. y de 200 kb como máximo.</b></div>';
                } else {
                    //Si la imagen es correcta en tamaño y tipo
                    //Se intenta subir al servidor
                    if (move_uploaded_file($temp, 'imagenes/' . $archivo)) {
                        //Cambiamos los permisos del archivo a 777 para poder modificarlo posteriormente
                        //chmod('images/'.$archivo, 0777);
                        //Mostramos el mensaje de que se ha subido co éxito
                        echo '<div><b>Se ha subido correctamente la imagen.</b></div>';
                        //Mostramos la imagen subida
                        //echo '<p><img src="imagenes/' . $archivo . '"></p>';
                    } else {
                        //Si no se ha podido subir la imagen, mostramos un mensaje de error
                        echo '<div><b>Ocurrió algún error al subir el fichero. No pudo guardarse.</b></div>';
                    }
                }
            }
        }
    }
    function crearCarpetaPedido(){
        $estructura = './pedido/';
        if (!mkdir($estructura, 0777, true)){
            echo "Fallo al crear la carpeta";
        }
    }

    function ultimoPedido(){
        $consulta = "SELECT idPedido FROM pedidos WHERE 1";

        $resultado = $this->conexion->consultas($consulta);
        while ( $fila = $this->conexion->extraerFila($resultado)){
            return $fila['idPedido'];
        }


    }

}