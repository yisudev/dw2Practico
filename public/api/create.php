<?php
// Configuramos el encabezado para que el contenido devuelto sea de tipo JSON
header("Content-Type: application/json");

// Incluimos el archivo de conexión a la base de datos
include '../includes/db.php'; 

// Decodificamos los datos JSON recibidos en el cuerpo de la solicitud
$data = json_decode(file_get_contents('php://input'), true);

// Asignamos valores de los datos recibidos a variables
$nombre = isset($data['nombre']) ? $data['nombre'] : '';
$apellido = isset($data['apellido']) ? $data['apellido'] : '';
$cumple = isset($data['cumple']) ? $data['cumple'] : '';
$email = isset($data['email']) ? $data['email'] : '';
$celular = isset($data['celular']) ? $data['celular'] : '';

// Validamos que los campos obligatorios no estén vacíos
if (empty($nombre) || empty($apellido) || empty($email)) {
    // Si alguno de los campos obligatorios está vacío, devolvemos un error 400
    $response = array("error" => "Los campos nombre, apellido y email son obligatorios.");
    http_response_code(400); 
    echo json_encode($response);
    exit;
}

// Preparamos la consulta SQL para insertar un nuevo registro en la tabla 'personas'
$stmt = $conn->prepare("INSERT INTO personas (doce_nombre, doce_apellido, per_cumple, per_mail, doce_cel) VALUES (?, ?, ?, ?, ?)");

// Vinculamos los parámetros a la consulta SQL
$stmt->bind_param("sssss", $nombre, $apellido, $cumple, $email, $celular);

// Ejecutamos la consulta y verificamos si se realizó correctamente
if ($stmt->execute()) {
    // Si la ejecución es exitosa, devolvemos un mensaje de éxito
    $response = array("message" => "Nuevo registro creado exitosamente");
    echo json_encode($response);
} else {
    // Si ocurre un error, devolvemos un mensaje de error con detalles
    $response = array("error" => "Error al crear registro: " . $stmt->error);
    echo json_encode($response);
}

// Cerramos la declaración preparada y la conexión a la base de datos
$stmt->close();
$conn->close();
?>
