<?php
session_start();

// Verificar autenticación
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

ob_start();

header('Content-Type: application/json; charset=utf-8');

$uploadDir = 'uploads/';
$dataFile = 'images_data.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filename'])) {
    $filename = $_POST['filename'];
    $filepath = $uploadDir . $filename;
    
    if (file_exists($filepath)) {
        if (!unlink($filepath)) {
            ob_end_clean();
            echo json_encode(['success' => false, 'message' => 'No se pudo eliminar el archivo físico']);
            exit;
        }
    }
    
    if (file_exists($dataFile)) {
        $images = json_decode(file_get_contents($dataFile), true);
        
        if ($images === null) {
            ob_end_clean();
            echo json_encode(['success' => false, 'message' => 'Error al leer el archivo JSON']);
            exit;
        }
        
        $images = array_filter($images, function($img) use ($filename) {
            return $img['filename'] !== $filename;
        });
        $images = array_values($images);
        
        foreach ($images as $index => &$img) {
            $img['order'] = $index;
        }
        
        $jsonData = json_encode($images, JSON_PRETTY_PRINT);
        if ($jsonData === false) {
            ob_end_clean();
            echo json_encode(['success' => false, 'message' => 'Error al codificar JSON']);
            exit;
        }
        
        if (file_put_contents($dataFile, $jsonData) === false) {
            ob_end_clean();
            echo json_encode(['success' => false, 'message' => 'Error al guardar archivo']);
            exit;
        }
    }
    
    ob_end_clean();
    echo json_encode(['success' => true]);
    exit;
} else {
    ob_end_clean();
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    exit;
}
?>