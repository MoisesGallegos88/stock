    <?php
    session_start();

    // Verificar si el usuario está autenticado
    if (!isset($_SESSION['logged_in'])) { // <-- Paréntesis añadido
        header("Location: login.php");
        exit();
    }

    include 'conexion_db.php';
    ?>

    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Registro de Artículos</title>
        <a href="buscar_articulos.php">Buscador de Artículos</a>
        <style>
            body { font-family: Arial, sans-serif; max-width: 600px; margin: 20px auto; padding: 20px; }
            .form-group { margin-bottom: 15px; }
            label { display: block; margin-bottom: 5px; }
            input, select, textarea { width: 100%; padding: 8px; }
            button { background: #4CAF50; color: white; padding: 10px 20px; border: none; cursor: pointer; }
            button:hover { background: #45a049; }
            .error { color: red; margin: 10px 0; }
            .success { color: green; margin: 10px 0; }
            .user-info { position: absolute; top: 20px; right: 20px; text-align: right; }
            .logout { color: #dc3545; text-decoration: none; }
        </style>
    </head>
    <body>
        <!-- Barra de usuario -->
        <div class="user-info">
            Bienvenido, <?= htmlspecialchars($_SESSION['username']) ?>!<br>
            <a href="logout.php" class="logout">Cerrar Sesión</a>
        </div>

        <h2>Registro de Nuevo Artículo</h2>
        
        <?php if (isset($_GET['success'])): ?>
            <div class="success">¡Artículo guardado correctamente!</div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="error">Error: <?= htmlspecialchars($_GET['error']) ?></div>
        <?php endif; ?>

        <form action="guardar_articulo.php" method="POST">
            <div class="form-group">
                <label>Material:</label>
                <select name="id_material" required>
                    <?php
                    try {
                        $sql = "SELECT id, nombre_material FROM Materiales";
                        $stmt = $conn->query($sql);
                        
                        if ($stmt->rowCount() > 0) {
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='".htmlspecialchars($row['id'])."'>"
                                    .htmlspecialchars($row['nombre_material'])."</option>";
                            }
                        } else {
                            echo "<option value=''>No hay materiales registrados</option>";
                        }
                    } catch(PDOException $e) {
                        echo "<option value=''>Error cargando materiales: ".$e->getMessage()."</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>Nombre del artículo:</label>
                <input type="text" name="nombre_articulo" required>
            </div>

            <div class="form-group">
                <label>Descripción:</label>
                <textarea name="descripcion"></textarea>
            </div>

            <div class="form-group">
                <label>Costo de compra:</label>
                <input type="number" step="0.01" name="costo_compra" required>
            </div>

            <div class="form-group">
                <label>Peso del artículo (gramos):</label>
                <input type="number" step="0.01" name="peso_articulo" required>
            </div>

            <button type="submit">Guardar Artículo</button>
        </form>
    </body>
    </html>