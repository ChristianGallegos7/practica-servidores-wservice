<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$cedula = $data['cedula'];
$nombre = $data['nombre'];
$edad = $data['edad'];
$cuenta_bancaria = $data['cuenta_bancaria'];
$producto = $data['producto'];
$cantidad = $data['cantidad'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tienda";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insertar datos en la tabla compras
$sql = "INSERT INTO compras (cedula, nombre, edad, cuenta_bancaria, producto, cantidad) VALUES ('$cedula', '$nombre', $edad, '$cuenta_bancaria', '$producto', $cantidad)";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["message" => "Compra guardada exitosamente"]);
} else {
    echo json_encode(["error" => "Error al guardar la compra: " . $conn->error]);
}

$conn->close();
?>
