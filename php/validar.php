<?php
$con = mysqli_connect('localhost', 'root', '', 'webauth');
$name = $_POST["usuario"];
$pass = $_POST["password"];
$query = "SELECT * FROM user_pwd WHERE name='$name' AND pass='$pass'";
$consulta = mysqli_query($con, $query);
$url = "";
$correcto;

if (mysqli_num_rows($consulta) > 0) {
	session_start();
	$_SESSION["usuario"] = $name;
	$url = "inicio";
	$correcto = true;
} else {
	$correcto = false;
}

$obj = (object) array('Correcto' => $correcto, 'Url' => $url);
echo json_encode($obj);
?>
