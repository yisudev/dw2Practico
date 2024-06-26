<?php
// Configuramos el encabezado para que el contenido devuelto sea de tipo JSON
header("Content-Type: application/json");

// Incluimos el archivo de conexión a la base de datos
include '../includes/db.php';

// Obtenemos el valor del ID de los parámetros GET y lo validamos
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Preparamos la consulta SQL dependiendo de si se ha proporcionado un ID o no
if ($id) {
    $sql = "SELECT * FROM personas WHERE id=$id";
} else {
    $sql = "SELECT * FROM personas";
}

// Ejecutamos la consulta SQL
$result = $conn->query($sql);

// Verificamos si se encontraron resultados
if ($result->num_rows > 0) {
    // Si se encontraron resultados, los almacenamos en un array
    $data = array();
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    // Devolvemos los resultados en formato JSON con un código de respuesta 200 (OK)
    http_response_code(200);
    echo json_encode($data);
} else {
    // Si no se encontraron resultados, devolvemos un mensaje de error con un código de respuesta 404 (No encontrado)
    http_response_code(404);
    echo json_encode(["message" => "No se encontraron registros"]);
}

// Cerramos la conexión a la base de datos
$conn->close();
?>
