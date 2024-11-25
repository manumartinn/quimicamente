<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = strtoupper($_POST['nombre']);
    $dni = $_POST['dni'];
    $puntaje = $_POST['puntaje'];
    $tiempo = $_POST['tiempo'];  // El tiempo llega en formato mm:ss:SS desde el frontend

    // Verificar si el DNI ya está registrado
    $stmt_check = $conn->prepare("SELECT COUNT(*) as cuenta FROM resultados WHERE dni = ?");
    $stmt_check->bind_param("s", $dni);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $row_check = $result_check->fetch_assoc();

    if ($row_check['cuenta'] > 0) {
        echo "Error: El DNI ya está registrado.";
    } else {
        // Cambia el tipo de dato de puntaje y tiempo
        $stmt = $conn->prepare("INSERT INTO resultados (nombre, dni, puntaje, tiempo) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $nombre, $dni, $puntaje, $tiempo); // Asegúrate de que 'tiempo' sea un string
        
        if ($stmt->execute()) {
            echo "Resultado guardado correctamente.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $stmt_check->close();
    $conn->close();
}
?>
