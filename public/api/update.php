<?php
header("Content-Type: application/json");
include '../includes/db.php'; 
$data = json_decode(file_get_contents("php://input"));

$id = $data->id;
$nombre = $data->nombre;
$apellido = $data->apellido;
$cumple = $data->cumple;
$email = $data->email;
$celular = $data->celular;

if (empty($id) || empty($nombre) || empty($apellido) || empty($email)) {
    $response = array("error" => "Los campos ID, nombre, apellido y email son obligatorios.");
    http_response_code(400); // Bad Request
    echo json_encode($response);
    exit;
}



$stmt = $conn->prepare("UPDATE personas SET doce_nombre=?, doce_apellido=?, per_cumple=?, per_mail=?, doce_cel=? WHERE id=?");
$stmt->bind_param("sssssi", $nombre, $apellido, $cumple, $email, $celular, $id);

if ($stmt->execute()) {
    http_response_code(200);
    echo json_encode(["message" => "Registro actualizado exitosamente"]);
} else {
    http_response_code(500);
    echo json_encode(["message" => "Error al actualizar registro: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
