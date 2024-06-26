<?php
// Configuramos el encabezado para que el contenido devuelto sea de tipo JSON
header("Content-Type: application/json");

// Incluimos el archivo de conexión a la base de datos
include '../includes/db.php'; 

// Decodificamos los datos JSON recibidos en el cuerpo de la solicitud
$data = json_decode(file_get_contents("php://input"));

// Asignamos el valor del ID recibido a una variable, validando que sea un entero
$id = isset($data->id) ? intval($data->id) : 0;

// Verificamos si el ID es válido (mayor que 0)
if ($id <= 0) {
    // Si el ID no es válido, devolvemos un error
    $response = array("error" => "ID inválido proporcionado.");
    http_response_code(400); 
    echo json_encode($response);
    exit;
}

// Preparamos la consulta SQL para eliminar el registro con el ID proporcionado
$sql = "DELETE FROM personas WHERE id=$id";

// Ejecutamos la consulta SQL y verificamos si se ejecutó correctamente
if ($conn->query($sql) === TRUE) {
    // Si la consulta se ejecutó correctamente, devolvemos un mensaje de éxito
    http_response_code(200);
    echo json_encode(["message" => "Registro eliminado exitosamente"]);
} else {
    // Si hubo un error al ejecutar la consulta, devolvemos un mensaje de error
    http_response_code(500);
    echo json_encode(["message" => "Error al eliminar registro: " . $conn->error]);
}

// Cerramos la conexión a la base de datos
$conn->close();
?>
