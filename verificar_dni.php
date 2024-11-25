<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dni = $_POST['dni'];

    $stmt = $conn->prepare("SELECT COUNT(*) as cuenta FROM resultados WHERE dni = ?");
    $stmt->bind_param("s", $dni);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    echo json_encode(['existe' => $row['cuenta'] > 0]);

    $stmt->close();
    $conn->close();
}
?>
