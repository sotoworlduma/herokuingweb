<?php
# Las claves de acceso, las ponemos aquí
# y en otro ejercicio las ponemos en una base de datos
// $usuario_correcto = "usuario";
// $password_correcto = "usuario";

// $usuario = $_POST["usuario"];
// $password = $_POST["password"];

$usuario_correcto = null;
$password_correcto = null;

$usuario = null;
$password = null;

if(isset($_POST["usuario"]) && !empty(trim($_POST["usuario"])) && isset($_POST["password"]) && !empty(trim($_POST["password"]))){
    require_once "config.php";
    $usuario = $_POST["usuario"];
    $password = $_POST["password"];
    $sql = "SELECT * FROM userpass WHERE usuario = ?";//var_dump($sql);
    if($stmt = mysqli_prepare($link, $sql)){var_dump("entra");
        mysqli_stmt_bind_param($stmt, "s", $param_user);
        $param_user = trim($_POST["usuario"]);
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);//var_dump($result);die;
            if(mysqli_num_rows($result) == 1){
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $usuario_correcto = $row["usuario"];
                $password_correcto = $row["pass"];
            } else{
                header("location: error.php");
                exit();
            }
        } else{
            echo "Oops! Algo fue mal. Por favor, intentelo de nuevo.";
        }
    }else {
      //var_dump("No conecta");var_dump($link);
    }//var_dump($usuario);var_dump($usuario_correcto);var_dump($password);var_dump($password_correcto);die;
    mysqli_stmt_close($stmt);
    mysqli_close($link);
}

# Luego de haber obtenido los valores, ya podemos comprobar:
if ($usuario === $usuario_correcto && $password === $password_correcto) {
    # Significa que coinciden, así que vamos a guardar algo
    # en el arreglo superglobal $_SESSION, ya que ese arreglo
    # "persiste" a través de todas las páginas

    # Iniciar sesión para poder usar el arreglo
    session_start();
    # Y guardar un valor que nos pueda decir si el usuario
    # ya ha iniciado sesión o no. En este caso es el nombre
    # de usuario
    $_SESSION["usuario"] = $usuario;

    # Luego redireccionamos a la página "Secreta"
    header("Location: item.php");
} else {

     header("Location: formulario.html");
}
