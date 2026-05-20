<?php
declare(strict_types=1);

require_once __DIR__ . '/conn.php';

header('X-Content-Type-Options: nosniff');

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    echo 'Método no permitido';
    exit;
}

$nombre = trim((string)($_POST['nombre'] ?? ''));
$correo = trim((string)($_POST['correo'] ?? ''));
$mensaje = trim((string)($_POST['mensaje'] ?? ''));

$db = conn();

// Crea la tabla si todavía no existe (útil en proyectos nuevos).
$db->query(
    "CREATE TABLE IF NOT EXISTS contactos (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT,
        nombre VARCHAR(120) NOT NULL,
        correo VARCHAR(190) NOT NULL,
        mensaje VARCHAR(1000) NOT NULL,
        creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY idx_correo (correo)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
);

$stmt = $db->prepare('INSERT INTO contactos (nombre, correo, mensaje) VALUES (?, ?, ?)');
$stmt->bind_param('sss', $nombre, $correo, $mensaje);
$stmt->execute();

// Respuesta amigable para formulario normal (no AJAX).
header('Location: index.html?enviado=1');
exit;