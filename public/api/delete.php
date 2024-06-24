<?php
header("Content-Type: application/json");
include '../includes/db.php'; 
$data = json_decode(file_get_contents("php://input"));

$id = $data->id;
$id = isset($data->id) ? intval($data->id) : 0;
if ($id <= 0) {
    $response = array("error" => "ID inválido proporcionado.");
    http_response_code(400); 
    echo json_encode($response);
    exit;
}

$sql = "DELETE FROM personas WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    http_response_code(200);
    echo json_encode(["message" => "Registro eliminado exitosamente"]);
} else {
    http_response_code(500);
    echo json_encode(["message" => "Error al eliminar registro: " . $conn->error]);
}

$conn->close();
?>
