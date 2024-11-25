<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .medalla-dorada {
            background-color: gold; /* Color dorado */
        }
        
        .position{
            font-weight: bold;
            width: 2%;
        }

        table{
            text-align: center;
        }

        .tiempo{
            width: 15%;
        }
    </style>
</head>
<body>
    <h1>Resultados del Quiz</h1>
    <table>
        <thead>
            <tr>
                <th>Posición</th> <!-- Nueva columna para el recuento -->
                <th>ID</th>
                <th>Nombre</th>
                <th>DNI</th>
                <th>Puntaje</th>
                <th>Tiempo</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include 'conexion.php';
            $sql = "SELECT * FROM resultados ORDER BY puntaje DESC, tiempo ASC";
            $result = $conn->query($sql);
            $isFirstRow = true; // Variable para identificar el primer puesto
            $position = 1; // Contador para las posiciones

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Aplicar clase dorada solo en la primera fila
                    $rowClass = $isFirstRow ? 'medalla-dorada' : '';
                    echo "<tr class='{$rowClass}'>
                            <td class='position'>{$position}</td> <!-- Columna para la posición -->
                            <td>{$row['id']}</td> <!-- Asegúrate de que la columna ID esté en la base de datos -->
                            <td>{$row['nombre']}</td>
                            <td>{$row['dni']}</td>
                            <td>{$row['puntaje']}</td>
                            <td class='tiempo'>{$row['tiempo']}</td>
                          </tr>";
                    $isFirstRow = false; // Cambiar a false después de la primera fila
                    $position++; // Incrementar el contador de posición
                }
            } else {
                echo "<tr><td colspan='6'>No hay resultados.</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>
