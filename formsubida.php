<?php
session_start();
if (empty($_SESSION["usuario"]) && empty($_SESSION["google"])) {
    header("Location: formulario.html");
    exit();
}
?>
<!DOCTYPE html>
<html>
<body>
  <span id="cerrarsesion" style="right:5px;"><a href="logout.php">Cerrar sesión de
    <?php
    if ( isset($_SESSION["usuario"])) {
      echo $_SESSION["usuario"];
    }
    if ( isset($_SESSION["google"])) {
      echo $_SESSION["google"];
    }
    ?>
  </a></span><br><br>
<h2>Subir tu imagen</h2>
<form action="upload.php" method="post" enctype="multipart/form-data">
  busque una imagen:
  <input type="file" name="fileToUpload" id="fileToUpload"><br>
  <label for="">Texto junto a imagen</label><br>
  <textarea name="text" rows="8" cols="80"></textarea>
  <input type="submit" value="Guardar" name="submit">
</form>

</body>
</html>
