<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

include 'conexion_db.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
        .welcome { color: #333; margin-bottom: 20px; }
        .logout { color: #dc3545; text-decoration: none; }
    </style>
</head>
<body>
    <h2 class="welcome">Bienvenido, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
    <p>Has iniciado sesión correctamente</p>
    
    <a href="logout.php" class="logout">Cerrar Sesión</a>
</body>
</html>