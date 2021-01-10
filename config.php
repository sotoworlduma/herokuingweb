<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', '92.38.171.129');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'Zx171260225!');
define('DB_NAME', 'jose');

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($link === false){
    die("ERROR: No conecta la base de datos. " . mysqli_connect_error());
}
?>
