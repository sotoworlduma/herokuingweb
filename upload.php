
<?php
session_start();
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {

  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain fisset(ile formats
// && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif"
if($imageFileType != "jpg") {
  echo "Sorry, solo admito JPG,ni JPEG, ni PNG, ni GIF ni otros";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

require_once "config.php";
$sql = "INSERT INTO images (name, userpass_id, texto, googleuser) VALUES (?, ?, ?, ?)";

if($stmt = mysqli_prepare($link, $sql)){
    // Bind variables to the prepared statement as parameters
  /*  i 	la variable correspondiente es de tipo entero
      d 	la variable correspondiente es de tipo double
      s 	la variable correspondiente es de tipo string */
    mysqli_stmt_bind_param($stmt, "siss", $param_name, $param_usuario, $param_texto, $param_google);

    // Set parameters
    $param_name = pathinfo($_FILES['fileToUpload']['name'], PATHINFO_FILENAME);
    $param_usuario = isset($_SESSION["id"]) ? $_SESSION["id"] : null;
    $param_texto = isset($_POST["texto"]) ? $_POST["texto"] : 'Sin comentarios';
    $param_google = (isset($_SESSION["googlecorreo"]) ? $_SESSION["googlecorreo"] : null);
    //$param_fecha = date('Y-m-d H:i:s');

    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){
        // Records created successfully. Redirect to landing page

    }
}

    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
    header("location: imagenes.php");
    exit();
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}
?>
