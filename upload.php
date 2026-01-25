<?php
session_start();

// Verificar autenticación
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

header('Content-Type: application/json');

$uploadDir = 'uploads/';
$dataFile = 'images_data.json';

if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $file = $_FILES['image'];
        $duration = isset($_POST['duration']) ? (int)$_POST['duration'] : 5;
        
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($file['type'], $allowedTypes)) {
            echo json_encode(['success' => false, 'message' => 'Tipo de archivo no permitido']);
            exit;
        }
        
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '_' . time() . '.' . $extension;
        $filepath = $uploadDir . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            $images = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];
            
            $maxOrder = 0;
            foreach ($images as $img) {
                if (isset($img['order']) && $img['order'] > $maxOrder) {
                    $maxOrder = $img['order'];
                }
            }
            
            $images[] = [
                'filename' => $filename,
                'duration' => $duration,
                'order' => $maxOrder + 1,
                'uploaded' => date('Y-m-d H:i:s')
            ];
            
            file_put_contents($dataFile, json_encode($images, JSON_PRETTY_PRINT));
            
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al mover el archivo']);
        }
    } else {
        $error_msg = isset($_FILES['image']) ? 'Error código: ' . $_FILES['image']['error'] : 'No se recibió ningún archivo';
        echo json_encode(['success' => false, 'message' => $error_msg]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
?>