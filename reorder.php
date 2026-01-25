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

$dataFile = 'images_data.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fromIndex']) && isset($_POST['toIndex'])) {
    $fromIndex = (int)$_POST['fromIndex'];
    $toIndex = (int)$_POST['toIndex'];
    
    if (file_exists($dataFile)) {
        $images = json_decode(file_get_contents($dataFile), true);
        
        if ($images === null) {
            ob_end_clean();
            echo json_encode(['success' => false, 'message' => 'Error al leer el archivo JSON']);
            exit;
        }
        
        usort($images, function($a, $b) {
            return $a['order'] - $b['order'];
        });
        
        if ($fromIndex >= 0 && $fromIndex < count($images) && $toIndex >= 0 && $toIndex < count($images)) {
            $element = array_splice($images, $fromIndex, 1)[0];
            array_splice($images, $toIndex, 0, [$element]);
            
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
            
            ob_end_clean();
            echo json_encode(['success' => true]);
            exit;
        } else {
            ob_end_clean();
            echo json_encode(['success' => false, 'message' => 'Índices inválidos']);
            exit;
        }
    } else {
        ob_end_clean();
        echo json_encode(['success' => false, 'message' => 'No hay datos']);
        exit;
    }
} else {
    ob_end_clean();
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    exit;
}
?>