<?php
// Configuramos el encabezado para que el contenido devuelto sea de tipo JSON
header("Content-Type: application/json");

// Incluimos el archivo de conexión a la base de datos
include '../includes/db.php';

// Decodificamos los datos JSON recibidos en el cuerpo de la solicitud
$data = json_decode(file_get_contents("php://input"));

// Asignamos los valores de los datos recibidos a variables
$id = $data->id;
$nombre = $data->nombre;
$apellido = $data->apellido;
$cumple = $data->cumple;
$email = $data->email;
$celular = $data->celular;

// Validamos que los campos obligatorios no estén vacíos
if (empty($id) || empty($nombre) || empty($apellido) || empty($email)) {
    // Si alguno de los campos obligatorios está vacío, devolvemos un error 400
    $response = array("error" => "Los campos ID, nombre, apellido y email son obligatorios.");
    http_response_code(400); // Bad Request
    echo json_encode($response);
    exit;
}

// Preparamos la consulta SQL para actualizar el registro en la tabla 'personas'
$stmt = $conn->prepare("UPDATE personas SET doce_nombre=?, doce_apellido=?, per_cumple=?, per_mail=?, doce_cel=? WHERE id=?");

// Vinculamos los parámetros a la consulta SQL
$stmt->bind_param("sssssi", $nombre, $apellido, $cumple, $email, $celular, $id);

// Ejecutamos la consulta y verificamos si se realizó correctamente
if ($stmt->execute()) {
    // Si la ejecución es exitosa, devolvemos un mensaje de éxito
    http_response_code(200);
    echo json_encode(["message" => "Registro actualizado exitosamente"]);
} else {
    // Si ocurre un error, devolvemos un mensaje de error con detalles
    http_response_code(500);
    echo json_encode(["message" => "Error al actualizar registro: " . $stmt->error]);
}

// Cerramos la declaración preparada y la conexión a la base de datos
$stmt->close();
$conn->close();
?>
