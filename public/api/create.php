<?php
header("Content-Type: application/json");
include '../includes/db.php'; 

$data = json_decode(file_get_contents('php://input'), true);

$nombre = isset($data['nombre']) ? $data['nombre'] : '';
$apellido = isset($data['apellido']) ? $data['apellido'] : '';
$cumple = isset($data['cumple']) ? $data['cumple'] : '';
$email = isset($data['email']) ? $data['email'] : '';
$celular = isset($data['celular']) ? $data['celular'] : '';

if (empty($nombre) || empty($apellido) || empty($email)) {
    $response = array("error" => "Los campos nombre, apellido y email son obligatorios.");
    http_response_code(400); 
    echo json_encode($response);
    exit;
}

$stmt = $conn->prepare("INSERT INTO personas (doce_nombre, doce_apellido, per_cumple, per_mail, doce_cel) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $nombre, $apellido, $cumple, $email, $celular);

if ($stmt->execute()) {
    $response = array("message" => "Nuevo registro creado exitosamente");
    echo json_encode($response);
} else {
    $response = array("error" => "Error al crear registro: " . $stmt->error);
    echo json_encode($response);
}

$stmt->close();
$conn->close();
?>
