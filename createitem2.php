<?php  /*
session_start();
if (empty($_SESSION["usuario"]) && empty($_SESSION["google"])) {
    header("Location: formulario.html");
    exit();
}   */
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$name = $address = $texto = "";
$name_err = $address_err = $texto_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_name = trim($_POST["uploadedfile"]);
    if(empty($input_name)){
        $name_err = "Por favor ingrese el nombre del empleado.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name = $input_name;//$name_err = "Por favor ingrese un nombre válido.";
    } else{
        $name = $input_name;
    }

    // Validate address
    // $input_address = trim($_POST["address"]);
    // if(empty($input_address)){
    //     $address_err = "Por favor ingrese una dirección.";
    // } else{
    //     $address = $input_address;
    // }

    // Validate salary
    // $input_salary = trim($_POST["salary"]);
    // if(empty($input_salary)){
    //     $salary_err = "Por favor ingrese el monto del salario del empleado.";
    // } elseif(!ctype_digit($input_salary)){
    //     $salary_err = "Por favor ingrese un valor correcto y positivo.";
    // } else{
    //     $salary = $input_salary;
    // }

    // Check input errors before inserting in database
    if(empty($name_err) && empty($address_err) && empty($texto_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO images (name, userpass_id, texto, googleuser) VALUES (?, ?, ?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
          /*  i 	la variable correspondiente es de tipo entero
              d 	la variable correspondiente es de tipo double
              s 	la variable correspondiente es de tipo string */
            mysqli_stmt_bind_param($stmt, "siss", $param_name, $param_usuario, $param_texto, $param_google);

            // Set parameters
            $param_name = $name;
            $param_usuario = $_SESSION["id"] ? $_SESSION["id"] : 2;
            $param_texto = $texto;
            $param_google = null;
            //$param_fecha = date('Y-m-d H:i:s');

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: item.php");
                exit();
            } else{
                echo "Algo fue mal. Por favor, intentelo de nuevo.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agregar Item</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Agregar Item</h2>
                    </div>
                    <p>Favor rellene el siguiente formulario, para agregar el registro.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Subir Imagen</label>
                            <!-- <input type="text" name="name" class="form-control" value="

                            "> -->
                            <input name="uploadedfile" type="file">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($texto_err)) ? 'has-error' : ''; ?>">
                            <label>Comentario</label>
                            <textarea name="texto" class="form-control"><?php echo $texto; ?></textarea>
                            <span class="help-block"><?php echo $texto_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="enviar">
                        <a href="item.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
