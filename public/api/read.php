<?php
header("Content-Type: application/json");
include '../includes/db.php';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id) {
    $sql = "SELECT * FROM personas WHERE id=$id";
} else {
    $sql = "SELECT * FROM personas";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $data = array();
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    http_response_code(200);
    echo json_encode($data);
} else {
    http_response_code(404);
    echo json_encode(["message" => "No se encontraron registros"]);
}

$conn->close();
?>
