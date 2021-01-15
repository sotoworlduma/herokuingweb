<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <style type="text/css">
        .wrapper{
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>
<body>
  <?php
  session_start();
  if (empty($_SESSION["usuario"]) && empty($_SESSION["google"])) {
      header("Location: formulario.html");
      exit();
  }
  ?>
    <div class="wrapper">
        <div class="container-fluid">
          <span id="cerrarsesion" style="right:5px;"><a href="logout.php">Cerrar sesión de
            <?php
            if ( isset($_SESSION["usuario"])) {
              echo $_SESSION["usuario"];
            }
            if ( isset($_SESSION["google"])) {
              echo $_SESSION["google"];
            }
            ?>
          </a></span>
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Imagenes</h2>
                        <a href="formsubida.php" class="btn btn-success pull-right">Agregar nueva imagen</a>
                    </div>
                    <?php
                    // Include config file
                    require_once "config.php";

                    // Attempt select query execution
                    $sql = "SELECT * FROM images";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Nombre</th>";
                                        echo "<th>Texto</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td><img src='uploads/" . $row['name'] . ".jpg'></img></td>";
                                        echo "<td>" . $row['texto'] . "</td>";
                                        echo "<td>";

                                        echo "<a href='deleteimagen.php?id=". $row['id'] ."' title='Borrar' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'>B</span></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No existen registros.</em></p>";
                        }
                    } else{
                        echo "ERROR: No ha sido posible ejecutar $sql. " . mysqli_error($link);
                    }

                    // Close connection
                    mysqli_close($link);
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
