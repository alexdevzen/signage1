<?php
header('Content-Type: application/json');

$dataFile = 'images_data.json';

if (file_exists($dataFile)) {
    $images = json_decode(file_get_contents($dataFile), true);
    
    foreach ($images as $index => &$img) {
        if (!isset($img['order'])) {
            $img['order'] = $index;
        }
    }
    
    usort($images, function($a, $b) {
        return $a['order'] - $b['order'];
    });
    
    file_put_contents($dataFile, json_encode($images, JSON_PRETTY_PRINT));
    
    echo json_encode(['success' => true, 'images' => $images]);
} else {
    echo json_encode(['success' => true, 'images' => []]);
}
?>