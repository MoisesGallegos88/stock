<?php
include 'conexion_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validar datos
        $id_material = filter_input(INPUT_POST, 'id_material', FILTER_VALIDATE_INT);
        $nombre = trim($_POST['nombre_articulo']);
        $descripcion = trim($_POST['descripcion']);
        $costo = filter_input(INPUT_POST, 'costo_compra', FILTER_VALIDATE_FLOAT);
        $peso = filter_input(INPUT_POST, 'peso_articulo', FILTER_VALIDATE_FLOAT);

        // Validaciones estrictas
        if (empty($id_material)) throw new Exception("Selecciona un material");
        if (empty($nombre)) throw new Exception("Nombre del artículo requerido");
        if ($costo <= 0) throw new Exception("Costo debe ser mayor a 0");
        if ($peso <= 0) throw new Exception("Peso debe ser mayor a 0");

        // Insertar datos
        $sql = "INSERT INTO Articulos 
                (id_material, nombre_articulo, descripcion, costo_compra, peso_articulo)
                VALUES (:id_material, :nombre, :descripcion, :costo, :peso)";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':id_material' => $id_material,
            ':nombre' => htmlspecialchars($nombre),
            ':descripcion' => htmlspecialchars($descripcion),
            ':costo' => $costo,
            ':peso' => $peso
        ]);

        header("Location: index.php?success=1");
        exit();

    } catch(PDOException $e) {
        header("Location: index.php?error=" . urlencode("Error de base de datos: " . $e->getMessage()));
        exit();
    } catch(Exception $e) {
        header("Location: index.php?error=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>