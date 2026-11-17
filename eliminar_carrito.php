<?php
/**
 * ACCIÓN PHP: ELIMINAR REGISTRO DEL CARRITO EN MYSQL
 * PROYECTO FINAL - PROGRAMACIÓN WEB II
 */
session_start();
require_once __DIR__ . '/config/conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$id_carrito = filter_input(INPUT_POST, 'id_carrito', FILTER_VALIDATE_INT);

if (!$id_carrito) {
    header("Location: carrito.php?error=" . urlencode("Identificador de ítem no válido."));
    exit();
}

try {
    // Eliminar el ítem específico perteneciente al usuario activo de la tabla CARRITO
    $stmtDelete = $pdo->prepare("DELETE FROM CARRITO WHERE id = ? AND id_usuario = ?");
    $stmtDelete->execute([$id_carrito, $_SESSION['usuario_id']]);

    header("Location: carrito.php?msg=" . urlencode("Libro eliminado del carrito."));
    exit();
} catch (PDOException $e) {
    header("Location: carrito.php?error=" . urlencode("Error al eliminar de la base de datos: " . $e->getMessage()));
    exit();
}
?>
