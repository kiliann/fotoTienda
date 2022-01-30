<?php



Class Metodos{
    public function __construct(){
        require_once 'Conexion.php';
        $this->conexion = new Conexion();

    }

    //Aqui realizamos el alta de usuario
    function altaUsuario($nombre, $correo, $password, $rpassword,  $telefono)
    {
        if ($password==$rpassword){

            $password_encry = password_hash($password, PASSWORD_BCRYPT);
            $insercion = "INSERT INTO clientes(nombre, correo, contrasena) VALUES ('$correo','$nombre','$password_encry', $telefono)";
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
        }else{
            echo "La contraseña no es correcta";
        }


    }
}